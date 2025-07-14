<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Promotion;
use Masmerise\Toaster\Toaster;

class EditPromotionSlideForm extends Component
{
    public $show = false;
    public $promotion = [];
    
    public $title;
    public $description;
    public $startDate;
    public $endDate;
    public $price;
    public $isActive;
    public $arrangement;

    public function mount($promotion)
    {
        $this->promotion = $promotion;
        $this->title = $promotion->title;
        $this->description = $promotion->description;
        $this->startDate = $promotion->startDate;
        $this->endDate = $promotion->endDate;
        $this->price = $promotion->price;
        $this->isActive = $promotion->isActive;
        $this->arrangement = $promotion->arrangement;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'max:255|string',
            'startDate' => 'required',
            'endDate' => 'required|after:startDate',
            'price' => 'required|min:0',
            'arrangement' => 'min:0',
        ], 
        [
            'title.required' => 'Promotion name is required.',
            'description.max' => 'Description cannot exceed to 255 characters.',
            'startDate.required' => 'Start Date must not be empty',
            'endDate.required' => 'End Date must not be empty',
            'endDate.after' => 'End Date must be greater than the start date.',
            'price.required' => 'Price must be greater than 0',
            'arrangement.min' => 'Order must be greater than 0',
        ]);

        $promotion = Promotion::find($this->promotion->id);

        $isUpdated = $promotion->update([
            'title' => $this->title,
            'description' => $this->description,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'price' => $this->price,
            'arrangement' => $this->arrangement,
            'isActive' => $this->isActive,
        ]);
        sleep(2);
        if($isUpdated)
        {
            $this->closeModal();
            $this->dispatch('updatedPromotion');
            Toaster::success('Promotion information updated successfully');

        }
        else
            Toaster::error('Failed to update promotion. Please contact administrator.');
    }

    public function openModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.promotion.edit-promotion-slide-form');
    }
}
