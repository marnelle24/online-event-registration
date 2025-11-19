<?php

namespace App\Livewire\Frontpage;

use App\Models\Ministry;
use Livewire\Component;

class MinistryLogosCarousel extends Component
{
    public $ministries = [];

    public function mount()
    {
        // Get published ministries that have logos
        $this->ministries = Ministry::all();
    }

    public function render()
    {
        return view('livewire.frontpage.ministry-logos-carousel');
    }
}

