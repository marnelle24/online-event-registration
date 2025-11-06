<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public $selectedPeriod = '30'; // days

    public function updatedSelectedPeriod()
    {
        // This will trigger a re-render with new data
        $this->dispatch('period-updated');
    }
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'selectedPeriod' => $this->selectedPeriod,
        ]);
    }
}

