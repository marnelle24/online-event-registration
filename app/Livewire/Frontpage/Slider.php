<?php

namespace App\Livewire\Frontpage;

use Livewire\Component;

class Slider extends Component
{
    public $isCarousel;

    public function mount($isCarousel)
    {
        $this->isCarousel = $isCarousel;
    }

    public function render()
    {
        return view('livewire.frontpage.slider');
    }
}
