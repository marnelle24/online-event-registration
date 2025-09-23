<?php

namespace App\Livewire\Promocode;

use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditPromocode extends Component
{
    public $promocode;

    public $code;
    public $startDate;
    public $endDate;
    public $price;
    public $maxUses;
    public $remarks;
    public $isActive;

    public function mount($promocode)
    {
        $this->promocode = $promocode;

        $this->code = $promocode->promocode;
        $this->startDate = $promocode->startDate;
        $this->endDate = $promocode->endDate;
        $this->price = $promocode->price;
        $this->maxUses = $promocode->maxUses;
        $this->remarks = $promocode->remarks;
        $this->isActive = $promocode->isActive;
    }

    public function save()
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'price' => 'required|numeric|min:0',
            'maxUses' => 'nullable|integer|min:0',
            'remarks' => 'nullable|string|max:255',
            'isActive' => 'boolean'
        ]);

        try
        {
            $this->promocode->update([
                'promocode' => $this->code,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'price' => $this->price,
                'maxUses' => $this->maxUses ?? 0,
                'remarks' => $this->remarks,
                'isActive' => $this->isActive,
            ]);

            sleep(2);

            Toaster::success('Promocode updated successfully');
            $this->dispatch('close-modal');
            $this->dispatch('updatedPromocode');
        }
        catch (\Exception $e)
        {
            \Log::error($e->getMessage());
            Toaster::error('Error updating promocode: ' . $e->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.promocode.edit-promocode');
    }
}
