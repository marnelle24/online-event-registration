<?php

namespace App\Livewire\Admin\Promocode;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Promocode;
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
    public $show = false;

    protected $listeners = [
        'callEditPromocodeModal' => 'openEditPromocodeModal',
    ];

    public function closeModal()
    {
        $this->show = false;
    }
    public function openEditPromocodeModal($promocodeId)
    {
        $this->show = true;
        $this->promocode = Promocode::find($promocodeId);

        $this->code = $this->promocode->promocode;
        $this->startDate = optional($this->promocode->startDate)->format('Y-m-d\TH:i');
        $this->endDate = optional($this->promocode->endDate)->format('Y-m-d\TH:i');
        $this->price = $this->promocode->price;
        $this->maxUses = $this->promocode->maxUses;
        $this->remarks = $this->promocode->remarks;
        $this->isActive = $this->promocode->isActive;
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
                'startDate' => $this->startDate ? Carbon::parse($this->startDate) : null,
                'endDate' => $this->endDate ? Carbon::parse($this->endDate) : null,
                'price' => $this->price,
                'maxUses' => $this->maxUses ?? 0,
                'remarks' => $this->remarks,
                'isActive' => $this->isActive,
            ]);

            sleep(2);

            Toaster::success('Promocode updated successfully');
            $this->closeModal();
            $this->dispatch('updatedPromocode')->to('admin.promocode.all-promocode');
        }
        catch (\Exception $e)
        {
            \Log::error($e->getMessage());
            Toaster::error('Error updating promocode: ' . $e->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.admin.promocode.edit-promocode');
    }
}
