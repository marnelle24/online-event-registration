<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;

class SpeakerSlideForm extends Component
{
    public $show = false;
    public $search = '';
    public $programmeId;

    protected $listeners = [
        'selectedSpeaker' => 'closeModal',
        'successAssignment' => 'closeModal'
    ];


    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
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
        return view('livewire.speaker.speaker-slide-form');
    }
}
