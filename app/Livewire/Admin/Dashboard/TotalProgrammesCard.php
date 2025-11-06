<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Programme;

class TotalProgrammesCard extends Component
{
    public int $totalProgrammes = 0;
    public int $activeProgrammes = 0;

    public function mount(): void
    {
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $this->totalProgrammes = Programme::withoutGlobalScopes()
            ->where('soft_delete', false)
            ->count();

        $this->activeProgrammes = Programme::where('soft_delete', false)
            ->where('status', 'published')
            ->where('publishable', true)
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.total-programmes-card');
    }
}


