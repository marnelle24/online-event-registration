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

    public function selectCategory($categoryId = 'all')
    {
        $this->selectedCategoryId = $categoryId;
        
        if ($categoryId == 'all') {
            $this->loadProgrammes();
        } else {
            $this->updateProgrammesList($categoryId);
        }
    }

    public function loadProgrammes()
    {
        if ($this->selectedCategoryId) 
        {
            $this->programmes = Programme::with(['categories', 'speakers', 'ministry'])
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

    // update the programmes list based on the selected category id
    public function updateProgrammesList($categoryId)
    {
        // find the  programmes from the list of programmes loaded in $this->programmes where the category is based on the selected category id
        $this->programmes = Programme::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with(['categories', 'speakers', 'ministry'])
            ->where('publishable', true)
            ->where('searchable', true)
            ->where('status', 'published')
            ->orderBy('startDate', 'asc')
            ->limit(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontpage.category-programme-carousel');
    }
}
