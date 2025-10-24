<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditCategory extends Component
{
    public $category;
    public $name;
    public $slug;
    public $show = false;
    public $loading = false;

    protected $listeners = [
        'callEditCategoryModal' => 'openModal',
    ];

    public function getCategoryData($categoryId)
    {
        $this->category = Category::find($categoryId);
        
        if (!$this->category) {
            throw new \Exception('Category not found');
        }

        // Populate form fields with existing data
        $this->name = $this->category->name;
        $this->slug = $this->category->slug;
    }

    public function openModal($id)
    {
        $this->loading = true;
        $this->show = true;
        
        try {
            $this->getCategoryData($id);
            $this->loading = false;
        } catch (\Exception $e) {
            $this->loading = false;
            $this->show = false;
            Toaster::error('Error loading category data: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function resetForm()
    {
        if ($this->category) {
            $this->name = $this->category->name;
            $this->slug = $this->category->slug;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
        ], [
            'name.required' => 'Category name is required.',
            'name.unique' => 'A category with this name already exists.',
        ]);

        try {
            $updated = $this->category->update([
                'name' => $validatedData['name'],
            ]);

            sleep(1);

            if ($updated) {
                Toaster::success('Category updated successfully!');
                $this->show = false;
                $this->dispatch('updatedCategory');
            } else {
                Toaster::error('Error updating category!');
            }
        } catch (\Exception $e) {
            \Log::error('Error updating category: ' . $e->getMessage());
            Toaster::error('Error updating category: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.category.edit-category');
    }
}
