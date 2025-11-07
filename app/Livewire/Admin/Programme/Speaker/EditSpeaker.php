<?php

namespace App\Livewire\Admin\Programme\Speaker;

use App\Models\Speaker;
use App\Models\Programme;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditSpeaker extends Component
{
    public $programme;

    public $loading = false;
    public $show = false;

    public $speakerID;
    public $type;
    public $details;


    protected $listeners = [
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'callEditSpeakerModal' => 'openModal',
    ]; 

    public function openModal($programmeId, $speakerId)
    {
        $this->loading = true;
        $this->show = true;
        
        try 
        {
            $this->getSpeakerData($programmeId, $speakerId);
            $this->loading = false;
        } 
        catch (\Exception $e) 
        {
            $this->loading = false;
            $this->show = false;
            Toaster::error('Error loading speaker data: ' . $e->getMessage());
        }
    }

    public function getSpeakerData($programmeId, $speakerId)
    {
        $this->speakerID = $speakerId;
        $this->programme = Programme::find($programmeId);
        $this->type = $this->programme->speakers()->where('speaker_id', $this->speakerID)->first()->pivot->type;
        $this->details = $this->programme->speakers()->where('speaker_id', $this->speakerID)->first()->pivot->details;
    }

    public function closeModal()
    {
        $this->show = false;
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
            $this->closeModal();
            $this->dispatch('updatechanges')->to('admin.programme.speaker.all-speaker');
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
        return view('livewire.admin.programme.speaker.edit-speaker', [
            'speakers' => $speakers
        ]);
    }
}
