<?php

namespace App\Livewire\Admin\Promocode;

use Livewire\Component;
use App\Models\Programme;
use App\Models\Promocode;
use Masmerise\Toaster\Toaster;

class AddPromocode extends Component
{
    public $programmeId;
    public $programme;

    public $promocode;
    public $startDate;
    public $endDate;
    public $price;
    public $maxUses;
    public $remarks;
    public $isActive;

    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
    }

    public function save()
    {
        $this->validate([
            'promocode' => 'required',
            'startDate' => 'required',
            'endDate' => 'required|after:startDate',
            'price' => 'required|integer|min:1',
            'maxUses' => 'nullable|integer|min:0',
            'remarks' => 'nullable|string|max:255',
            'isActive' => 'boolean'
        ]);

        try
        {
            $this->programme->promocodes()->create([
                'promocode' => $this->promocode,
                'programCode' => $this->programme->programmeCode,
                'price' => $this->price,
                'maxUses' => $this->maxUses ?? 0,
                'remarks' => $this->remarks,
                'isActive' => $this->isActive,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'createdBy' => auth()->user()->name,
            ]);

            sleep(2); 

            Toaster::success('Promocode added successfully');
            $this->resetForm();
            $this->dispatch('newAddedPromocode');
            $this->dispatch('close-modal');
        }
        catch (\Exception $e)
        {
            \Log::error($e);
            // Toaster::error('Failed to add promocode');
            Toaster::error('Error updating promotion: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'promocode',
            'startDate',
            'endDate',
            'price',
            'maxUses',
            'remarks',
            'isActive'
        ]);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.promocode.add-promocode');
    }
}
