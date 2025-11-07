<?php

namespace App\Livewire\Admin\Registrant;

use Livewire\Component;

class DetailsSliderView extends Component
{
    public $show = false;
    public $registrant = [];

    public function mount($registrant) 
    {
        $this->registrant = $registrant;
    }

    public function openModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.admin.registrant.details-slider-view');
    }
}
