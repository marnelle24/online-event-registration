<?php

namespace App\Livewire\Admin\Promotion;

use Livewire\Component;
use App\Models\Promotion;
use Masmerise\Toaster\Toaster;
use Carbon\Carbon;

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

    public $show = false;

    protected $listeners = [
        'callEditPromotionModal' => 'openEditPromotionModal',
    ];

    public function closeModal()
    {
        $this->show = false;
    }

    public function openEditPromotionModal($promotionId)
    {
        $this->show = true;
        $this->promotion = Promotion::find($promotionId);

        $this->title = $this->promotion->title;
        $this->description = $this->promotion->description;
        $this->startDate = optional($this->promotion->startDate)->format('Y-m-d\TH:i');
        $this->endDate = optional($this->promotion->endDate)->format('Y-m-d\TH:i');
        $this->price = $this->promotion->price;
        $this->isActive = $this->promotion->isActive;
        $this->arrangement = $this->promotion->arrangement;
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
                'startDate' => $this->startDate ? Carbon::parse($this->startDate) : null,
                'endDate' => $this->endDate ? Carbon::parse($this->endDate) : null,
                'price' => $this->price,
                'isActive' => $this->isActive,
                'arrangement' => $this->arrangement,
            ]);

            sleep(1);

            if($updated) {
                Toaster::success('Promotion updated successfully!');
                $this->closeModal();
                $this->dispatch('updatedPromotion')->to('admin.promotion.all-promotion');
                $this->show = false;
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
        return view('livewire.admin.promotion.edit-promotion');
    }
}
