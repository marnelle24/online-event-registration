<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Masmerise\Toaster\Toaster;

class CategoryForm extends Component
{
    public $categoryId;
    public $name = '';
    public $slug = '';
    public $isEditing = false;
    public $notification = '';

    protected $listeners = ['category-selected' => 'selectCategory'];

    public function selectCategory(Category $category)
    {
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate(
            [
                'name' => 'required|min:4',
                'slug' => 'nullable',
            ],
            [
                'name.required' => 'Name must not empty.',
                'name.min' => 'Name is too short',
            ]
        );

        
        // Data to be updated or created
        try {
            $category = Category::updateOrCreate(
                [ 
                    'id' => $this->categoryId
                ], 
                [
                    'name' => $this->name,
                    'slug' => ($this->slug) ? $this->slug : null
                ]
            );
            $this->dispatch('category-saved');

            Toaster::success('Saved changes successfully!');
            
            $this->cancelEdit();
        } 
        catch (\Exception $e) {
            Toaster::error('Failed to save changes!');
        }
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'slug', 'categoryId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.category.category-form');
    }
}
