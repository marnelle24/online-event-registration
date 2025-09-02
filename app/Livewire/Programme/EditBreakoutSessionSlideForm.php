<?php

namespace App\Livewire\Programme;

use Livewire\Component;

class EditBreakoutSessionSlideForm extends Component
{
    public $show = false;
    public $breakout;
    public $title;
    public $description;
    public $startDate;
    public $endDate;
    public $price;
    public $isActive;
    public $order;
    public $speaker_id;
    public $location;

    public function mount($breakout)
    {
        $this->breakout = $breakout;
        $this->title = $breakout->title;
        $this->description = $breakout->description;
        $this->startDate = $breakout->startDate;
        $this->endDate = $breakout->endDate;
        $this->price = $breakout->price;
        $this->isActive = $breakout->isActive;
        $this->order = $breakout->order;
        $this->speaker_id = $breakout->speaker_id;
        $this->location = $breakout->location;
    }

    public function openModal()
    {
        $this->show = true;
    }
    
    public function closeModal()
    {
        $this->show = false;
    }
    
    // public function save()
    // {
    //     $this->validate([
    //         'breakout.title' => 'required',
    //         'breakout.description' => 'nullable',
    //     ]);
    // }
    
    public function render()
    {
        return view('livewire.programme.edit-breakout-session-slide-form');
    }
}
