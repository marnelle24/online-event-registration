<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Programme;

class TopProgrammesCard extends Component
{
    public $topProgrammes;

    public function mount(): void
    {
        $this->loadTopProgrammes();
    }

    protected function loadTopProgrammes(): void
    {
        $this->topProgrammes = Programme::where('soft_delete', false)
            ->with('ministry')
            ->withCount('registrations')
            ->orderBy('registrations_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.top-programmes-card');
    }
}


