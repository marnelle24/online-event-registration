<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AddCategory extends Component
{
    public $name;
    public $slug;

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Category name is required.',
            'name.unique' => 'A category with this name already exists.',
        ]);

        try {
            $category = Category::create([
                'name' => $validatedData['name'],
            ]);

            sleep(1);

            if ($category) {
                Toaster::success('Category created successfully!');
                $this->resetForm();
                $this->dispatch('newAddedCategory');
            } else {
                Toaster::error('Error creating category!');
            }
        } catch (\Exception $e) {
            \Log::error('Error creating category: ' . $e->getMessage());
            Toaster::error('Error creating category: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.category.add-category');
    }
}
