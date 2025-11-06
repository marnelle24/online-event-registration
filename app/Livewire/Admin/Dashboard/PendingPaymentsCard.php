<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Registrant;

class PendingPaymentsCard extends Component
{
    public int $pendingPayments = 0;
    public int $verifiedPayments = 0;

    public function mount(): void
    {
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $query = Registrant::where('soft_delete', false);

        $this->pendingPayments = (clone $query)
            ->where('paymentStatus', 'pending')
            ->count();

        $this->verifiedPayments = (clone $query)
            ->where('paymentStatus', 'verified')
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.pending-payments-card');
    }
}


