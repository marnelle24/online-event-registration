<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;

class SpeakerDropDownListSelect extends Component
{
    public $search;
    public $label = 'Search for Speakers or Trainers';
    public $speakers;

    public function mount()
    {
        $this->search = ''; // Default search term
        $this->speakers = Speaker::latest()
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->select('id', 'name', 'title', 'profession', 'thumbnail')
        ->take(10)
        ->get();
    }

    public function render()
    {       
        return view('livewire.speaker.speaker-drop-down-list-select');
    }

    public function selectSpeaker($speakerId)
    {
        $this->dispatch('selectedSpeaker', $speakerId);
    }
}
