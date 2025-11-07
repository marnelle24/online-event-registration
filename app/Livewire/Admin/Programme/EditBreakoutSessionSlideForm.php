<?php

namespace App\Livewire\Admin\Programme;

use App\Models\Speaker;
use Livewire\Component;
use App\Models\Breakout;
use Masmerise\Toaster\Toaster;

class EditBreakoutSessionSlideForm extends Component
{
    public $breakout;
    public $allSpeakers = [];
    
    // Form properties
    public $session_title = '';
    public $session_description = '';
    public $start_datetime = '';
    public $end_datetime = '';
    public $speaker = '';
    public $location = '';
    public $price = 0;
    public $order = 0;
    public $isActive = true;

    public function mount($breakout)
    {
        $this->breakout = $breakout;
        $this->allSpeakers = Speaker::all();
        
        // Populate form fields with existing data
        $this->session_title = $breakout->title;
        $this->session_description = $breakout->description;
        $this->start_datetime = $breakout->startDate;
        $this->end_datetime = $breakout->endDate;
        $this->price = $breakout->price;
        $this->isActive = $breakout->isActive;
        $this->order = $breakout->order;
        $this->speaker = $breakout->speaker_id;
        $this->location = $breakout->location;
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
            $updated = $this->breakout->update([
                'title' => $this->session_title,
                'description' => $this->session_description,
                'startDate' => $this->start_datetime,
                'endDate' => $this->end_datetime,
                'price' => $this->price,
                'location' => $this->location,
                'speaker_id' => $this->speaker,
                'order' => $this->order,
                'isActive' => $this->isActive,
            ]);

            sleep(1);
            
            if($updated)
            {
                Toaster::success('Breakout session updated successfully!');
                \Log::info('Breakout session updated successfully: ' . $this->breakout->id);
                $this->dispatch('breakoutUpdated');
                $this->dispatch('close-modal');
            }
            else
            {
                Toaster::error('Failed to update breakout session');
                \Log::error('Failed to update breakout session: ' . $this->breakout->id);
            }

            
        } 
        catch (\Exception $e) {
            Toaster::error('Failed to update breakout session');
            \Log::error($e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.admin.programme.edit-breakout-session-slide-form');
    }
}
