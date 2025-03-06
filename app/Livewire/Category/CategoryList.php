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
        $category = Category::find($categoryId);
        if ($category) {
            $category->delete();
            Toaster::error('Category deleted successfully!');
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
