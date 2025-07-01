<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use App\Models\Programme;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public ?string $search = '';

    public $programmeSpeakers;
    public $programmeId;

    protected $listeners = [
        'selectedSpeaker' => 'getSelectedSpeaker',
        'newSpeakerCreated' => 'assignNewSpeaker'
    ];

    public function assignNewSpeaker($data)
    {
        $programme = Programme::find($this->programmeId);
        $programme->speakers()->attach($data[0], [
            'type' => $data[1],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Toaster::success('Speaker assigned to programme successfully');
        $this->programmeSpeakers = $programme->speakers()->with('media')->get();
    }
    
    public function getSelectedSpeaker($speakerId)
    {
        $programme = Programme::find($this->programmeId);
        if($programme->speakers()->where('speaker_id', $speakerId)->exists())
        {
            // $programme->speakers()->detach($speakerId);
            Toaster::error('Speaker already assigned in this programme');
        }
        else
        {
            $programme->speakers()->attach($speakerId, [
                'type' => 'speaker',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Toaster::success('Speaker assigned to programme successfully');
        }
        $this->programmeSpeakers = $programme->speakers()->with('media')->get();
    }

    public function removeSpeaker($speakerId)
    {
        $programme = Programme::find($this->programmeId);
        if($programme->speakers()->where('speaker_id', $speakerId)->exists())
        {
            $programme->speakers()->detach($speakerId);
            Toaster::success('Speaker removed successfully in this programme.');
        }
        $this->programmeSpeakers = $programme->speakers()->with('media')->get();
    }

    public function getFilteredSpeakersProperty()
    {
        if (trim($this->search) === '') {
            return $this->programmeSpeakers;
        }
        return $this->programmeSpeakers->filter(function ($speaker) {
            return stripos($speaker->name, $this->search) !== false
                || stripos($speaker->email, $this->search) !== false;
        });
    }


    public function render()
    {
        // dd($this->programmeSpeakers);
        // $speakers = collect();

        // if (isset($this->programmeSpeakers))
        //     $speakers = $this->programmeSpeakers->load('media');
        // else
        // {

        //     // $speakers = Speaker::query()
        //     //     ->with('media')
        //     //     ->when($this->search, function ($query) {
        //     //         $query->where('name', 'like', "%{$this->search}%");
        //     //         $query->orWhere('email', 'like', "%{$this->search}%");
        //     //         $query->orWhere('title', 'like', "%{$this->search}%");
        //     //     })
                
        //     //     ->latest('created_at')
        //     //     ->get();
        // }

        return view('livewire.speaker.index');
    }
}
