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

    public $programmeSpeakers;
    public $programmeId;
    public $programme = [];

    protected $listeners = [
        'selectedSpeaker' => 'getSelectedSpeaker',
        'successAssignment' => 'render'
    ];


    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
        $this->programme = Programme::find($this->programmeId);
    }

    public function removeSpeaker($speakerId)
    {
        $this->programme->speakers()->detach($speakerId);
        Toaster::success('Removed successfully from this programme.');
        $this->render();
    }

    public function render()
    {
        $ps = $this->programme->speakers;
        return view('livewire.speaker.index', [
            'ps' => $ps
        ]);
    }
}
