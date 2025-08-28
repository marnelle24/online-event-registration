<?php

namespace App\Livewire\Programme;

use Livewire\Component;

class BreakoutSessionSlideForm extends Component
{
    public $programmeId;
    public $show = true;
    
    // Form properties
    public $session_title = '';
    public $session_description = '';
    public $start_time = '';
    public $end_time = '';
    public $speaker = '';
    public $location = '';

    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
    }

    public function openModal()
    {
        $this->show = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->session_title = '';
        $this->session_description = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->speaker = '';
        $this->location = '';
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'session_title' => 'required|string|max:255',
            'session_description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'speaker' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // Here you would save the breakout session
        // For now, just show a success message
        session()->flash('message', 'Breakout session created successfully!');
        
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.programme.breakout-session-slide-form');
    }
}
