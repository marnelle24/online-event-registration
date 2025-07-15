<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Programme;
use App\Models\Promotion;
use Masmerise\Toaster\Toaster;

class PromotionSlideForm extends Component
{
    public $show = false;
    public $programmeId;
    public $form = [
        'title' => 'Book test promotion',
        'description' => 'this is the Book test promotion',
        'startDate' => '2025-07-01 12:20:00',
        'endDate' => '2025-07-28 12:20:00',
        'price' => '99',
        'isActive' => false,
        'arrangement' => 0,
    ];

    public function mount($programmeId)
    {
        $this->programmeId = $programmeId;
        // Set the class based on your requirements
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
            'form.title' => 'required',
            'form.description' => 'max:255|string',
            'form.startDate' => 'required',
            'form.endDate' => 'required|after:form.startDate',
            'form.price' => 'required|min:0',
        ], 
        [
            'form.title.required' => 'Promotion name is required.',
            'form.description.max' => 'Description cannot exceed to 255 characters.',
            'form.startDate.required' => 'Start Date must not be empty',
            'form.endDate.required' => 'End Date must not be empty',
            'form.endDate.after' => 'End Date must be greater than the start date.',
            'form.price.required' => 'Price must be greater than 0',
        ]);

        $programme = Programme::find($this->programmeId);
        $this->form['programCode'] = $programme->programmeCode ?? NULL;
        $this->form['programme_id'] = $this->programmeId;
        $this->form['createdBy'] = auth()->user()->name;
        
        $save = Promotion::create($this->form);
        sleep(2); 
        if($save)
        {
            $this->resetForm();
            $this->closeModal();
            Toaster::success('New promotion created successfully');
            $this->dispatch('newAddedPromotion');
        }
        else
            Toaster::error('Failed to create promotion. Please contact administrator.');
        

    }

    public function resetForm()
    {
        $this->reset(['form']);
        $this->resetValidation();
    }
    
    public function render()
    {
        return view('livewire.promotion.promotion-slide-form');
    }
}
