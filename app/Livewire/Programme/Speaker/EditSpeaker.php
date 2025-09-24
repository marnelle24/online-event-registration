<?php

namespace App\Livewire\Programme\Speaker;

use App\Models\Speaker;
use App\Models\Programme;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditSpeaker extends Component
{
    public $speaker;

    public $programmeId;
    public $programme;

    public $speakerID;
    public $type;
    public $details;

    public function mount($speaker)
    {
        $this->speaker = $speaker;

        $this->programme = Programme::find($this->programmeId);

        $this->speakerID = $speaker->id;
        $this->type = $speaker->pivot->type;
        $this->details = $speaker->pivot->details;
    }

    public function save()
    {
        $this->validate([
            'speakerID' => 'required',
            'type' => 'required',
            'details' => 'required',
        ]);

        try 
        {
            if($this->programme->speakers()->where('speaker_id', $this->speakerID)->exists())
            {
                $this->programme->speakers()->updateExistingPivot($this->speakerID, [
                    'type' => $this->type,
                    'details' => $this->details,
                ]);
            }
            else
            {
                $this->programme->speakers()->attach($this->speakerID, [
                    'type' => $this->type,
                    'details' => $this->details,
                ]);
            }

            sleep(1);
            
            Toaster::success('Updated successfully');
            $this->dispatch('close-modal');
            $this->dispatch('updatechanges');
        } 
        catch (\Exception $e) 
        {
            \Log::error($e->getMessage());
            Toaster::error('Failed to update speaker');
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
        $speakers = Speaker::orderBy('name', 'asc')->get();
        return view('livewire.programme.speaker.edit-speaker', [
            'speakers' => $speakers
        ]);
    }
}
