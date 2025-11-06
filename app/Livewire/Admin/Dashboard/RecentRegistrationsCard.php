<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Registrant;

class RecentRegistrationsCard extends Component
{
    public $recentRegistrations;

    public function mount(): void
    {
        $this->loadRecentRegistrations();
    }

    protected function loadRecentRegistrations(): void
    {
        $this->recentRegistrations = Registrant::where('soft_delete', false)
            ->with('programme')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.recent-registrations-card');
    }
}


