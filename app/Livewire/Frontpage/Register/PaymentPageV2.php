<?php

namespace App\Livewire\Frontpage\Register;

use App\Models\Registrant;
use App\Services\Payment\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PaymentPageV2 extends Component
{
    public string $confirmationCode;

    public ?Registrant $registrant = null;

    public Collection $groupMembers;

    public bool $isPaid = false;

    public array $paymentMethods = [];

    public ?string $selectedMethod = null;

    public bool $loading = false;

    public ?string $alertType = null;

    public ?string $alertMessage = null;

    public array $bankTransferInstructions = [];

    public array $paymentResult = [];

    public bool $showBankTransferModal = false;

    public array $bankDetails = [];

    public bool $hitpayProcessing = false;

    public ?string $hitpayError = null;

    public function mount(string $confirmationCode): void
    {
        $this->showBankTransferModal = true;

        $this->confirmationCode = $confirmationCode;
        $this->groupMembers = collect();

        $this->loadRegistrant();
        $this->loadPaymentMethods();

        $this->getBankTransferDetails();
    }

    public function render(): View
    {
        return view('livewire.frontpage.register.payment-page-v2');
    }

    public function selectMethod(string $method): void
    {
        if (!collect($this->paymentMethods)->pluck('key')->contains($method)) {
            return;
        }

        $this->selectedMethod = $method;

        if ($method === 'bank_transfer') 
        {
            $this->processBankTransfer();
        } 
        else 
        {
            $this->initiatePayment();
        }
        // $this->bankTransferInstructions = [];
        // $this->paymentResult = [];
        // $this->alertType = null;
        // $this->alertMessage = null;
    }

    protected function processBankTransfer(): void
    {
        if (!$this->registrant) {
            return;
        }

        $this->validate([
            'selectedMethod' => ['required', Rule::in(collect($this->paymentMethods)->pluck('key')->all())],
        ]);

        $this->showBankTransferModal = true;
    }

    // create a function that will get the bank details to display in the bank_transfer option once the component is mounted
    protected function getBankTransferDetails(): void
    {
        if (!$this->registrant) {
            return;
        }

        $paymentService = new PaymentService();
        $result = $paymentService->getBankDetails();

        $this->bankDetails = $result ?? [];
    }

    public function initiatePayment($paymentMethod = null): void
    {
        if (!$this->registrant || !$paymentMethod) {
            return;
        }
        
        $this->loading = true;
        $this->alertType = null;
        $this->alertMessage = null;
        $this->bankTransferInstructions = [];
        $this->paymentResult = [];

        try {
            $paymentService = new PaymentService();
            $result = $paymentService->processPayment($this->registrant->fresh(), $paymentMethod);

            $this->paymentResult = $result['data'] ?? [];

            if ($result['success']) {
                if ($paymentMethod === 'bank_transfer') {
                    $this->bankTransferInstructions = $this->paymentResult['instructions'] ?? [];
                    $this->alertType = 'info';
                    $this->alertMessage = 'Bank transfer instructions have been generated. Please follow the steps below.';
                    $this->showBankTransferModal = true;
                } else {
                    $this->alertType = 'success';
                    $this->alertMessage = 'Payment initiated successfully.';

                    if (!empty($this->paymentResult['redirect_url'])) 
                    {
                        $url = json_encode($this->paymentResult['redirect_url']);
                        $this->js("window.location.href = {$url}");
                        $this->alertMessage = 'Redirecting you to the payment gateway...';
                    }
                }
            } else {
                $this->alertType = 'error';
                $this->alertMessage = $result['error'] ?? 'Payment processing failed.';
            }
        } catch (\Throwable $throwable) {
            report($throwable);
            $this->alertType = 'error';
            $this->alertMessage = 'An unexpected error occurred while processing your payment. Please try again.';
        } finally {
            $this->loading = false;
            $this->loadRegistrant();
        }
    }

    public function closeBankTransferModal(): void
    {
        $this->showBankTransferModal = false;
    }

    public function showBankTransferInstructions(): void
    {
        if (!$this->registrant) {
            return;
        }

        // Load bank transfer instructions if not already loaded
        if (empty($this->bankTransferInstructions)) 
        {
            $paymentService = new PaymentService();
            
            // Use reflection to access protected method, or prepare data manually
            $paymentData = [
                'registrant_id' => $this->registrant->id,
                'confirmationCode' => $this->registrant->confirmationCode,
                'amount' => $this->registrant->netAmount,
                'currency' => 'SGD', // Singapore Dollar - ISO 4217 currency code
                'description' => "Registration for {$this->registrant->programme->title}",
                'contact_email' => $this->registrant->programme->contactEmail,
            ];

            $gateway = $paymentService->getGateway('bank_transfer');
            $result = $gateway->initiatePayment($paymentData);
            $this->bankTransferInstructions = $result['instructions'] ?? [];
        }

        $this->showBankTransferModal = true;
    }

    protected function loadRegistrant(): void
    {
        $registrant = Registrant::with(['programme', 'promocode'])
            ->where('confirmationCode', $this->confirmationCode)
            ->firstOrFail();

        // if the net amount is 0, redirect to the confirmation page
        if ($registrant->netAmount <= 0) 
        {
            $this->redirectRoute('registration.confirmation', ['confirmationCode' => $this->confirmationCode]);
            return;
        }

        // check if the programme is allow pre registration
        if ($registrant->programme->allowPreRegistration) 
        {
            $this->redirectRoute('registration.confirmation', ['confirmationCode' => $this->confirmationCode]);
            return;
        }

        $this->registrant = $registrant;
        $this->isPaid = in_array( $registrant->paymentStatus, ['paid', 'group_member_paid', 'free'], true );

        $this->groupMembers = $registrant->groupRegistrationID
            ? Registrant::where('groupRegistrationID', $registrant->groupRegistrationID)
                ->where('confirmationCode', $this->confirmationCode)
                ->orderBy('id')
                ->get()
            : collect();
    }

    protected function loadPaymentMethods(): void
    {
        $paymentService = new PaymentService();

        $this->paymentMethods = collect($paymentService->getAvailablePaymentMethods())
            ->filter(fn (array $method) => $method['enabled'] ?? false)
            ->values()
            ->all();

        $this->selectedMethod = $this->selectedMethod
            ?? (collect($this->paymentMethods)->first()['key'] ?? null);
    }

    public function processHitPayPayment(): void
    {
        if (!$this->registrant) {
            $this->hitpayError = 'Registration not found. Please refresh the page.';
            return;
        }

        if ($this->hitpayProcessing) {
            return;
        }

        $this->hitpayProcessing = true;
        $this->hitpayError = null;
        $this->alertType = null;
        $this->alertMessage = null;

        try {
            $paymentService = new PaymentService();
            $result = $paymentService->processPayment($this->registrant->fresh(), 'hitpay');

            $this->paymentResult = $result['data'] ?? [];
            
            if ($result['success']) 
            {
                if (!empty($this->paymentResult['payment_url'])) 
                {
                    // Execute JavaScript to redirect
                    $url = json_encode($this->paymentResult['payment_url']);
                    $this->js("window.location.href = {$url}");
                } 
                else 
                {
                    throw new \Exception('Payment gateway did not return a valid URL');
                }
            } 
            else 
            {
                throw new \Exception($result['error'] ?? 'Payment processing failed.');
            }
        } catch (\Throwable $throwable) {
            report($throwable);
            $this->hitpayError = $throwable->getMessage() ?? 'Payment processing failed. Please try again.';
            $this->hitpayProcessing = false;
        }
    }
}

