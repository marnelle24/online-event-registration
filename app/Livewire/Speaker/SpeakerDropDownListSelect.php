<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class SpeakerDropDownListSelect extends Component
{
    public $details = '';
    public $type = '';
    public $speakerID = '';
    public $programmeId = '';

    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
    }

    public function saveChanges()
    {
        $validated = $this->validate([
            'speakerID' => 'required',
            'type' => 'required',
            'details' => 'nullable|string',
        ], [
            'speakerID.required' => 'Please select professional',
            'type.required' => 'Please assign role of the professional in the programme',
        ]);

        $programme = Programme::find($this->programmeId);
        $programme->speakers()->attach(
            $validated['speakerID'], 
            [
                'type' => $validated['type'], 
                'details' => $validated['details']
            ]
        );

        $msg = 'New '.$validated['type'].' added successfully.';
        sleep(1);
        Toaster::success($msg);
        $this->dispatch('successAssignment');
    }

    public function render()
    {      
        $speakers = Speaker::orderBy('name', 'ASC')->get();
        return view('livewire.speaker.speaker-drop-down-list-select', [
            'speakers' => $speakers
        ]);
    }
}
