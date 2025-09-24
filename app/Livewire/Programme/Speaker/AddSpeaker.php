<?php

namespace App\Livewire\Programme\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class AddSpeaker extends Component
{
    public $programmeId;
    public $speakers;
    public $programme;
    public $speakerID;
    public $type;
    public $details;

    public function mount()
    {
        $this->speakers = Speaker::orderBy('name', 'asc')->get();
        $this->programme = Programme::find($this->programmeId);
    }

    public function save()
    {
        $this->validate([
            'speakerID' => 'required',
            'type' => 'required',
            'details' => 'required',
        ], [
            'speakerID.required' => 'Please select speaker',
            'type.required' => 'Please select type',
            'details.required' => 'Please enter details',
        ]);

        try 
        {
            $this->programme->speakers()->attach($this->speakerID, [
                'type' => $this->type,
                'details' => $this->details,
            ]);

            sleep(1);

            Toaster::success('New role added successfully.');
            $this->resetForm();
            $this->dispatch('close-modal');
            $this->dispatch('updatechanges');
        } 
        catch (\Exception $e) 
        {
            \Log::error($e->getMessage());
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->speakerID = '';
        $this->type = '';
        $this->details = '';
    }

    public function render()
    {
        return view('livewire.programme.speaker.add-speaker');
    }
}
