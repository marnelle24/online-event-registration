<?php

namespace App\Livewire\Speaker;

use Livewire\Component;

class SpeakerSlideForm extends Component
{
    public string $class;
    public $show = false;

    public function mount()
    {
        // Set the class based on your requirements
        $this->class = 'tracking-widest font-thin uppercase inline-flex items-center bg-slate-200 hover:scale-105 hover:bg-slate-200 duration-300 justify-center rounded-md border border-slate-400 py-2 px-3 text-center text-slate-500 drop-shadow text-xs';
    }
    protected $listeners = [
        'selectedSpeaker' => 'closeModal',
        'newSpeakerCreated' => 'closeModal'
    ];

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
