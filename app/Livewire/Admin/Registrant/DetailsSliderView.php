<?php

namespace App\Livewire\Admin\Registrant;

use Livewire\Component;
use App\Models\Registrant;
use App\Services\Payment\PaymentService;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;

class DetailsSliderView extends Component
{
    public $show = false;
    public $registrantId;
    public $registrant;
    
    // Form fields for bank transfer verification
    public $bankTransactionReference;
    public $verificationNotes;
    public $showBankTransferForm = false;
    
    // Status update fields
    public $newRegStatus;
    public $newPaymentStatus;
    public $showStatusUpdateForm = false;

    public function mount($registrant) 
    {
        if (is_object($registrant)) {
            $this->registrantId = $registrant->id;
            // Load with relationships to ensure all data is available
            $this->loadRegistrant();
        } else {
            $this->registrantId = $registrant;
            $this->loadRegistrant();
        }
    }

    public function loadRegistrant()
    {
        $this->registrant = Registrant::with(['programme', 'promocode', 'promotion', 'groupMembersRelation'])
            ->findOrFail($this->registrantId);
    }

    public function openModal()
    {
        $this->show = true;
        $this->loadRegistrant();
    }

    public function closeModal()
    {
        $this->show = false;
        $this->reset(['bankTransactionReference', 'verificationNotes', 'showBankTransferForm', 'showStatusUpdateForm']);
    }

    public function toggleBankTransferForm()
    {
        $this->showBankTransferForm = !$this->showBankTransferForm;
        if ($this->showBankTransferForm) {
            $this->bankTransactionReference = $this->registrant->paymentReferenceNo ?? '';
        }
    }

    public function toggleStatusUpdateForm()
    {
        $this->showStatusUpdateForm = !$this->showStatusUpdateForm;
        if ($this->showStatusUpdateForm) {
            $this->newRegStatus = $this->registrant->regStatus;
            $this->newPaymentStatus = $this->registrant->paymentStatus;
        }
    }

    public function verifyPayment()
    {
        $this->validate([
            'bankTransactionReference' => 'required|string|max:255',
            'verificationNotes' => 'nullable|string|max:1000',
        ]);

        try {
            $paymentService = new PaymentService();
            
            // Update payment reference if provided
            if ($this->bankTransactionReference && $this->bankTransactionReference !== $this->registrant->paymentReferenceNo) {
                $this->registrant->update([
                    'paymentReferenceNo' => $this->bankTransactionReference,
                ]);
            }

            // Verify and confirm payment
            $result = $paymentService->confirmPayment($this->registrant->confirmationCode, [
                'verified_by' => Auth::user()->name ?? 'Admin',
                'verified_at' => now(),
                'approvedBy' => Auth::user()->name ?? 'Admin',
                'approvedDate' => now(),
                'confirmedBy' => Auth::user()->name ?? 'Admin',
                'notes' => $this->verificationNotes,
            ]);

            if ($result) {
                $this->loadRegistrant();
                $this->reset(['bankTransactionReference', 'verificationNotes', 'showBankTransferForm']);
                Toaster::success('Payment verified and registration confirmed successfully.');
            } else {
                Toaster::error('Failed to verify payment. Please try again.');
            }
        } catch (\Exception $e) {
            Toaster::error('Error verifying payment: ' . $e->getMessage());
        }
    }

    public function confirmPayment()
    {
        try {
            $paymentService = new PaymentService();
            
            $result = $paymentService->confirmPayment($this->registrant->confirmationCode, [
                'verified_by' => Auth::user()->name ?? 'Admin',
                'verified_at' => now(),
                'approvedBy' => Auth::user()->name ?? 'Admin',
                'approvedDate' => now(),
                'confirmedBy' => Auth::user()->name ?? 'Admin',
            ]);

            if ($result) {
                $this->loadRegistrant();
                Toaster::success('Payment confirmed successfully.');
            } else {
                Toaster::error('Failed to confirm payment. Please try again.');
            }
        } catch (\Exception $e) {
            Toaster::error('Error confirming payment: ' . $e->getMessage());
        }
    }

    public function updateStatus()
    {
        $this->validate([
            'newRegStatus' => 'required|string|in:pending,confirmed,unpaid,cancelled',
            'newPaymentStatus' => 'required|string|in:pending,paid,unpaid,free,pending_verification,verified',
        ]);

        try {
            $updateData = [
                'regStatus' => $this->newRegStatus,
                'paymentStatus' => $this->newPaymentStatus,
            ];

            // If confirming, update additional fields
            if ($this->newRegStatus === 'confirmed' && $this->newPaymentStatus === 'paid') {
                $updateData['approvedBy'] = Auth::user()->name ?? 'Admin';
                $updateData['approvedDate'] = now();
                $updateData['confirmedBy'] = Auth::user()->name ?? 'Admin';
                $updateData['payment_verified_by'] = Auth::user()->name ?? 'Admin';
                $updateData['payment_verified_at'] = now();
                $updateData['payment_completed_at'] = now();
            }

            $this->registrant->update($updateData);
            $this->loadRegistrant();
            $this->reset(['showStatusUpdateForm', 'newRegStatus', 'newPaymentStatus']);
            
            Toaster::success('Registration status updated successfully.');
        } catch (\Exception $e) {
            Toaster::error('Error updating status: ' . $e->getMessage());
        }
    }

    public function processRefund()
    {
        // TODO: Integrate with HitPay API for refund processing
        // This is a placeholder method - actual API integration to be implemented later
        
        try {
            // Validate that payment is eligible for refund
            if ($this->registrant->paymentStatus !== 'paid') {
                Toaster::error('Only paid registrations can be refunded.');
                return;
            }

            if ($this->registrant->paymentOption !== 'hitpay') {
                Toaster::error('Refunds are currently only available for HitPay payments.');
                return;
            }

            // Check if payment was completed
            if (!$this->registrant->payment_completed_at) {
                Toaster::error('Payment completion date is missing. Cannot process refund.');
                return;
            }

            // TODO: Add refund logic here
            // Example structure:
            // 1. Call HitPay refund API
            // 2. Update registrant status
            // 3. Log refund transaction
            // 4. Send notification email
            
            // Placeholder: Update status to indicate refund is being processed
            // $this->registrant->update([
            //     'paymentStatus' => 'refund_pending',
            //     'regStatus' => 'cancelled',
            // ]);
            
            Toaster::info('Refund functionality will be integrated with HitPay API soon.');
            
        } catch (\Exception $e) {
            Toaster::error('Error processing refund: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.registrant.details-slider-view');
    }
}
