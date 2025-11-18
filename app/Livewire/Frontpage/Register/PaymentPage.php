<?php

namespace App\Livewire\Frontpage\Register;

use App\Models\Registrant;
use App\Services\Payment\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PaymentPage extends Component
{
    public string $confirmationCode;

    public ?Registrant $registrant = null;

    public Collection $groupMembers;

    public bool $isPaid = false;

    public bool $isPaymentInitiated = false;

    public bool $isRegistrationConfirmed = false;

    public array $paymentMethods = [];

    public ?string $selectedMethod = null;

    public bool $loading = false;

    public array $bankTransferInstructions = [];

    public array $paymentResult = [];

    public bool $showBankTransferModal = false;

    public array $bankDetails = [];

    public bool $hitpayProcessing = false;

    public ?string $hitpayError = null;

    public function mount(string $confirmationCode): void
    {
        $this->confirmationCode = $confirmationCode;
        $this->groupMembers = collect();

        $this->loadRegistrant();
        $this->loadPaymentMethods();

        $this->getBankTransferDetails();
    }

    public function render(): View
    {
        return view('livewire.frontpage.register.payment-page');
    }

    public function selectMethod(string $method): void
    {
        if (!collect($this->paymentMethods)->pluck('key')->contains($method)) {
            return;
        }

        $this->selectedMethod = $method;

        if ($method === 'bank_transfer') 
            $this->processBankTransfer();
        else 
            $this->initiatePayment();
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

    public function initiateBankTransferPayment(): void
    {
        if (!$this->registrant) {
            return;
        }

        $paymentService = new PaymentService();
        $result = $paymentService->processPayment($this->registrant->fresh(), 'bank_transfer');
        $this->paymentResult = $result['data'] ?? [];

        if ($result['success']) {
            $this->redirectRoute('registration.confirmation', ['confirmationCode' => $this->confirmationCode]);
        }
    }

    protected function loadRegistrant(): void
    {
        $registrant = Registrant::with(['programme', 'promocode', 'promotion'])
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

        // if the regisration is already confirmed, redirect to landing page
        if ($registrant->regStatus === 'confirmed') 
        {
            abort(404, 'Registration already confirmed.');
        }


        $this->registrant = $registrant;
        $this->isPaid = in_array( $registrant->paymentStatus, ['paid', 'group_member_paid', 'free'], true );
        $this->isPaymentInitiated = $registrant->payment_initiated_at !== null ? true : false;
        $this->isRegistrationConfirmed = $registrant->regStatus === 'confirmed' ? true : false;

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

