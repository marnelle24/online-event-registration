<?php

namespace App\Livewire\Promocode;

use Livewire\Component;
use App\Models\Programme;
use App\Models\Promocode;
use Masmerise\Toaster\Toaster;

class PromocodeSlideForm extends Component
{
    public $show = false;
    public $programmeId;

    public $form = [
        'promocode' => 'TEST2432',
        'remarks' => 'this is the Book test promotion',
        'startDate' => '2025-07-01 12:20:00',
        'endDate' => '2025-07-28 12:20:00',
        'price' => '10',
        'isActive' => false,
    ];


    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
    }

    public function openModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function save()
    {
        $this->validate([
            'form.promocode' => 'required',
            'form.remarks' => 'max:255|string',
            'form.startDate' => 'required',
            'form.endDate' => 'required|after:form.startDate',
            'form.price' => 'required|integer|min:1',
            'form.isActive' => 'boolean'
        ], 
        [
            'form.promocode.required' => 'Code is required.',
            'form.remarks.max' => 'Remarks cannot exceed to 255 characters.',
            'form.startDate.required' => 'Start Date must not be empty',
            'form.endDate.required' => 'End Date must not be empty',
            'form.endDate.after' => 'End Date must be greater than the start date.',
            'form.price.required' => 'Price is required.',
            'form.price.min' => 'Price must be greater than 0'
        ]);

        $programme = Programme::find($this->programmeId);
        $this->form['programCode'] = $programme->programmeCode ?? NULL;
        $this->form['programme_id'] = $this->programmeId;
        $this->form['createdBy'] = auth()->user()->name;


        $save = Promocode::create($this->form);

        sleep(2); 

        if($save)
        {
            $this->resetForm();
            $this->closeModal();
            Toaster::success('New promo code created successfully');
            $this->dispatch('newAddedPromocode');
        }
        else
            Toaster::error('Failed to create promo code. Please contact administrator.');
    }
    
    public function resetForm()
    {
        $this->reset(['form']);
        $this->resetValidation();
    }
    
    public function render()
    {
        return view('livewire.promocode.promocode-slide-form');
    }
}
