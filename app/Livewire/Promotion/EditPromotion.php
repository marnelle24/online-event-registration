<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditPromotion extends Component
{
    public $promotion;
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

        // Populate form fields with existing data
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'price' => 'required|numeric|min:0',
            'isActive' => 'nullable|boolean',
            'arrangement' => 'nullable|integer|min:0',
        ]);

        try {
            $updated = $this->promotion->update([
                'title' => $this->title,
                'description' => $this->description,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'price' => $this->price,
                'isActive' => $this->isActive,
                'arrangement' => $this->arrangement,
            ]);

            sleep(1);

            if($updated) {
                Toaster::success('Promotion updated successfully!');
                $this->dispatch('close-modal');
                $this->dispatch('updatedPromotion');
            }
            else {
                Toaster::error('Error updating promotion!');
            }
        }
        catch (\Exception $e) 
        {
            \Log::error('Error updating promotion: ' . $e->getMessage());
            Toaster::error('Error updating promotion: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.promotion.edit-promotion');
    }
}
