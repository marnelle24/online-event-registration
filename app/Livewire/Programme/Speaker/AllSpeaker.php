<?php

namespace App\Livewire\Programme\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\DB;

class AllSpeaker extends Component
{

    public $programmeId;
    public $programme;
    // public $speakers;

    protected $listeners = [
        'updatechanges' => 'refreshSpeakers',
    ];

    public function mount()
    {
        $this->programme = Programme::where('id', $this->programmeId)->first();
    }

    public function removeSpeaker($speakerId)
    {
        try 
        {
            $this->programme->speakers()->detach($speakerId);
            // $this->refreshSpeakers();
            Toaster::success('Speaker removed successfully.');
        } 
        catch (\Exception $e) 
        {
            \Log::error($e->getMessage());
            Toaster::error('Something wrong removing speaker. Please contact administrator.');
        }
    }

    public function refreshSpeakers()
    {
        $this->programme = Programme::where('id', $this->programmeId)->first();
        $this->speakers = $this->programme->speakers;
    }

    public function render()
    {
        return view('livewire.programme.speaker.all-speaker', [
            'speakers' => $this->programme->speakers
        ]);
    }
}
