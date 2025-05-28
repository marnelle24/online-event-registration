<?php

namespace App\Livewire\Speaker;

use Livewire\Component;

class SpeakerSlideForm extends Component
{
    protected $listeners = [
        'selectedSpeaker' => 'closeModal',
        'newSpeakerCreated' => 'closeModal'
    ];

    public $show = false;

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
        return view('livewire.speaker.speaker-slide-form');
    }
}
