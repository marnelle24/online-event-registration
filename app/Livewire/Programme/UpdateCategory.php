<?php

namespace App\Livewire\Programme;

use Livewire\Component;
use App\Models\Category;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class UpdateCategory extends Component
{
    public $programmeId;
    public $programmeCategories;
    public $programme;
    public $categories;
    public $selectedCategory;
    public $show = false;

    protected $listeners = ['category-updated' => 'render'];


    public function toogleShowEditCategory()
    {
        $this->show = !$this->show;
    }

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function getSelectedCategory()
    {
        $this->validate([
                'selectedCategory' => 'required',
            ], 
            [
                'selectedCategory.required' => 'Oops... please select a category!'
            ]
        );

        try
        {
            $this->programme->categories()->attach($this->selectedCategory);
            Toaster::success('Category added successfully!');
            $this->programmeCategories = $this->programme->categories;
            $this->selectedCategory = '';
            $this->resetForm();
        }
        catch (\Exception $e)
        {
            Toaster::error('Failed to add category!');
        }
    }

    public function resetForm()
    {
        $this->reset(['selectedCategory']);
        $this->resetValidation();
        $this->dispatch('category-updated');
        
    }

    public function render()
    {
        $this->programme = Programme::find($this->programmeId);
        $this->programmeCategories = $this->programme->categories;
        return view('livewire.programme.update-category', [
            'programmeCategories' => $this->programmeCategories
        ]);
    }
}
