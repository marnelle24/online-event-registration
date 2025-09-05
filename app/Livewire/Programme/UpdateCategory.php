<?php

namespace App\Livewire\Programme;

use Livewire\Component;
use App\Models\Category;
use App\Models\Programme;

class UpdateCategory extends Component
{
    public $programmeId;
    public $programmeCategories;
    public $programme;
    public $categories;
    public $show = false;


    public function toogleShowEditCategory()
    {
        $this->show = !$this->show;
    }

    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
        $this->programmeCategories = $this->programme->categories;
        $this->categories = Category::all();
    }
    
    public function render()
    {
        return view('livewire.programme.update-category');
    }
}
