<?php

namespace App\Livewire\Promocode;

use Livewire\Component;
use App\Models\Promocode;
use Masmerise\Toaster\Toaster;

class EditPromocodeSlideForm extends Component
{
    public $show = false;
    public $promocode = [];

    public $code;
    public $remarks;
    public $startDate;
    public $endDate;
    public $price;
    public $usedCount;
    public $maxUses;
    public $createdBy;
    public $isActive;

    public function mount($promocode)
    {
        $this->promocode = $promocode;
        $this->code = $promocode->promocode;
        $this->remarks = $promocode->remarks;
        $this->startDate = $promocode->startDate;
        $this->endDate = $promocode->endDate;
        $this->price = $promocode->price;
        $this->usedCount = $promocode->usedCount;
        $this->maxUses = $promocode->maxUses;
        $this->isActive = $promocode->isActive;
        $this->createdBy = $promocode->createdBy;
    }

    public function save()
    {
        $validated = $this->validate([
            'code' => 'required',
            'remarks' => 'max:255|string',
            'startDate' => 'required',
            'endDate' => 'required|after:startDate',
            'price' => 'required|min:0',
            'maxUses' => 'min:0',
            'isActive' => 'boolean'
        ], 
        [
            'code.required' => 'Promo code is required.',
            'remarks.max' => 'Description cannot exceed to 255 characters.',
            'startDate.required' => 'Start Date must not be empty',
            'endDate.required' => 'End Date must not be empty',
            'endDate.after' => 'End Date must be greater than the start date.',
            'price.required' => 'Price must be greater than 0',
            'maxUses.min' => 'Maximum usage must be greater than 0',
        ]);

        $promocode = Promocode::find($this->promocode->id);

        $isUpdated = $promocode->update([
            'promocode' => $validated['code'],
            'remarks' => $validated['remarks'],
            'startDate' => $validated['startDate'],
            'endDate' => $validated['endDate'],
            'price' => $validated['price'],
            'maxUses' => $validated['maxUses'],
            'isActive' => $validated['isActive'],
        ]);
        sleep(2);
        if($isUpdated)
        {
            $this->closeModal();
            $this->dispatch('updatedPromocode');
            Toaster::success('Promo code information updated successfully');
        }
        else
            Toaster::error('Failed to update promo code. Please contact administrator.');
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
        return view('livewire.promocode.edit-promocode-slide-form');
    }
}
