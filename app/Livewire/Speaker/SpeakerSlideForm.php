<?php

namespace App\Livewire\Speaker;

use Livewire\Component;

class SpeakerSlideForm extends Component
{
    public string $class;

    public function mount()
    {
        // Set the class based on your requirements
        $this->class = 'inline-flex items-center bg-slate-300 hover:bg-slate-400 duration-300 justify-center rounded-md border border-l-none border-slate-400 py-2.5 px-4 text-center font-medium text-slate-600 text-sm hover:bg-opacity-90';
    }
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
