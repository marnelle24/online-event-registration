<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class CategoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryToDelete = null;

    protected $listeners = ['category-saved' => '$refresh'];

    public function selectCategory(Category $category)
    {
        $this->dispatch('category-selected', category: $category);
    }

    public function deleteCategory($categoryId)
    {
        try {
            $category = Category::find($categoryId);
            $category->delete();
            Toaster::success('Category deleted successfully!');
        } catch (\Exception $e) {
            Toaster::error('Failed to delete category!');
        }
    }

    public function render()
    {
        $categories = Category::latest()
            ->where('name', 'like', "%{$this->search}%")
            ->paginate(10);

        return view('livewire.category.category-list', [
            'categories' => $categories
        ]);
    }
}
