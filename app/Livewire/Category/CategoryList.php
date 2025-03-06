<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $categories = Category::latest()
            ->where('name', 'like', "%{$this->search}%")
            ->paginate(6);

        return view('livewire.category.category-list', [
            'categories' => $categories
        ]);
    }
    
}
