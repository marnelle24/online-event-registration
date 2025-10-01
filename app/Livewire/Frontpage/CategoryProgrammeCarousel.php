<?php

namespace App\Livewire\Frontpage;

use App\Models\Category;
use App\Models\Programme;
use Livewire\Component;

class CategoryProgrammeCarousel extends Component
{
    public $selectedCategoryId = null;
    public $categories = [];
    public $programmes = [];

    public function mount()
    {
        // Only get categories that have published programmes
        $this->categories = Category::with(['programmes' => function ($query) {
            $query->where('publishable', true)
                  ->where('searchable', true)
                  ->where('status', 'published');
        }])->whereHas('programmes', function ($query) {
            $query->where('publishable', true)
                  ->where('searchable', true)
                  ->where('status', 'published');
        })->get();

        // Set the first category as default if available
        if ($this->categories->isNotEmpty()) {
            $this->selectedCategoryId = $this->categories->first()->id;
            $this->loadProgrammes();
        }
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        $this->loadProgrammes();
    }

    public function loadProgrammes()
    {
        if ($this->selectedCategoryId) 
        {
            $this->programmes = Programme::whereHas('categories', function ($query) {
                $query->where('categories.id', $this->selectedCategoryId);
            })
            ->with(['categories', 'speakers', 'ministry'])
            ->where('publishable', true)
            ->where('searchable', true)
            ->where('status', 'published')
            ->orderBy('startDate', 'asc')
            ->limit(6)
            ->get();
        } 
        else 
        {
            $this->programmes = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontpage.category-programme-carousel');
    }
}
