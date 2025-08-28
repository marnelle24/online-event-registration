<?php

namespace App\Livewire\Programme;

use Livewire\Component;
use App\Models\Programme;

class BreakoutSession extends Component
{
    public $programmeId;
    public $programme;

    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
    }

    public function render()
    {
        return view('livewire.programme.breakout-session');
    }
}
