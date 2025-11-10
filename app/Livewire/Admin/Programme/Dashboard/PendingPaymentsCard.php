<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Registrant;
use Illuminate\View\View;
use Livewire\Component;

class PendingPaymentsCard extends Component
{
    private const PENDING_STATUSES = [
        'pending',
        'pending_verification',
        'group_reg_pending',
        'group_member_pending',
        'unpaid',
    ];

    public int $programmeId;
    public int $pendingPayments = 0;
    public float $pendingValue = 0.0;
    public ?float $verificationShare = null;

    public function mount(int $programmeId): void
    {
        $this->programmeId = $programmeId;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $baseQuery = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->where('soft_delete', false);

        $pendingQuery = (clone $baseQuery)->whereIn('paymentStatus', self::PENDING_STATUSES);

        $this->pendingPayments = (clone $pendingQuery)->count();
        $this->pendingValue = (clone $pendingQuery)->sum('netAmount');

        $totalWithPayment = (clone $baseQuery)
            ->whereNotNull('paymentStatus')
            ->count();

        if ($totalWithPayment > 0) {
            $this->verificationShare = ($this->pendingPayments / $totalWithPayment) * 100;
        } else {
            $this->verificationShare = null;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.programme.dashboard.pending-payments-card');
    }
}

