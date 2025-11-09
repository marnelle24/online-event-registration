<?php

namespace App\Livewire\Admin\Programme;

use App\Models\Speaker;
use Livewire\Component;
use App\Models\Breakout;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class BreakoutSessionSlideForm extends Component
{
    public $programmeId;
    public $programme;
    public $allSpeakers = [];
    public bool $allowBreakoutSession;
    
    // Form properties
    public $session_title = '';
    public $session_description = '';
    public $start_datetime = '';
    public $end_datetime = '';
    public $speaker = '';
    public $location = '';
    public $price = 0;
    public $order = 0;

    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
        $this->programme = Programme::find($programmeId);
        $this->allSpeakers = Speaker::all();
        $this->allowBreakoutSession = $this->programme->allowBreakoutSession;
    }

    public function resetForm()
    {
        $this->session_title = '';
        $this->session_description = '';
        $this->start_datetime = '';
        $this->end_datetime = '';
        $this->speaker = '';
        $this->location = '';
        $this->price = 0;
        $this->order = 0;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'session_title' => 'required|string|max:255',
            'session_description' => 'nullable|string',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after:start_datetime',
            'speaker' => 'nullable|exists:speakers,id',
            'location' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'order' => 'nullable|integer|min:0',
        ]);
        
        try {
            $breakout = Breakout::create([
                'programme_id' => $this->programmeId,
                'programCode' => $this->programme->programmeCode,
                'title' => $this->session_title,
                'description' => $this->session_description,
                'startDate' => $this->start_datetime,
                'endDate' => $this->end_datetime,
                'price' => $this->price,
                'location' => $this->location,
                'speaker_id' => $this->speaker,
                'order' => $this->order,
                'createdBy' => auth()->user()->id,
            ]);

            sleep(1);
            
            if($breakout)
            {
                Toaster::success('Breakout session created successfully!');
                \Log::info('Breakout session created successfully in programme id: ' . $this->programmeId);
                $this->dispatch('newAddedBreakout');
            }
            else
            {
                Toaster::error('Failed to create breakout session');
                \Log::error('Failed to create breakout session in programme id: ' . $this->programmeId);
            }

            $this->resetForm();
        } 
        catch (\Exception $e) {
            Toaster::error('Failed to create breakout session');
            \Log::error($e->getMessage());
        }
        
    }

    public function render()
    {
        return view('livewire.admin.programme.breakout-session-slide-form');
    }
}
