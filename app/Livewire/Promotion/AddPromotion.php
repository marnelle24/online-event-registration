<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class AddPromotion extends Component
{
    public $programmeId;
    public $programme;

    public $title;
    public $description;
    public $startDate;
    public $endDate;
    public $price;
    public $isActive;
    public $arrangement = 0;

    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'price' => 'nullable|numeric',
            'isActive' => 'nullable|boolean',
            'arrangement' => 'nullable|integer',
        ]);

        try 
        {
            $this->programme->promotions()->create([
                'title' => $this->title,
                'programCode' => $this->programme->programmeCode,
                'description' => $this->description,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'price' => $this->price,
                'isActive' => $this->isActive,
                'createdBy' => auth()->user()->name,
                'arrangement' => $this->arrangement,
            ]);

            sleep(1);

            Toaster::success('Promotion added successfully!');
            \Log::info('Promotion added successfully in programme id: ' . $this->programmeId);

            $this->resetForm();
            $this->dispatch('newAddedPromotion');
            $this->dispatch('close-modal');
        }
        catch (\Exception $e) {
            Toaster::error('Failed to add promotion');
            \Log::error('Failed to add promotion in programme id: ' . $this->programmeId);
        }
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->price = 0;
        $this->isActive = false;
        $this->arrangement = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.promotion.add-promotion');
    }
}
