<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Registrant;

class PaymentStatusCard extends Component
{
    public array $paymentStatusDistribution = [];

    public function mount(): void
    {
        $this->loadDistribution();
    }

    protected function loadDistribution(): void
    {
        $statuses = ['pending', 'verified', 'failed', 'cancelled'];
        $distribution = [];

        foreach ($statuses as $status) {
            $distribution[$status] = Registrant::where('soft_delete', false)
                ->where('paymentStatus', $status)
                ->count();
        }

        $this->paymentStatusDistribution = $distribution;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.payment-status-card');
    }
}


