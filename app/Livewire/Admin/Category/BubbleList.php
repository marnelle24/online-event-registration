<?php

namespace App\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class BubbleList extends Component
{
    public $categories;
    public $programmeId;
    public $canRemove;

    protected $listeners = ['category-updated' => 'render'];

    public function mount($programmeId = NULL, $canRemove = false)
    {
        $this->canRemove = $canRemove;
        $this->programmeId = $programmeId;
    }

    public function removeCategory($categoryId)
    {
        if(!$this->canRemove)
            return;

        try
        {
            if($this->programmeId)
            {
                // dump('has programmeId');
                $programme = Programme::find($this->programmeId);
                $programme->categories()->detach($categoryId);
                $this->categories = $programme->categories;
            }
            else
            {
                // dump('no programmeId');
                $category = Category::find($categoryId);
                $category->delete();
                $this->categories = Category::all();
            }
            Toaster::success('Category removed successfully');
            $this->dispatch('category-updated');
        }
        catch (\Exception $e)
        {
            Toaster::error('Failed to remove category');
        }
    }
    
    public function render()
    {
        if($this->programmeId)
            $this->categories = Programme::find($this->programmeId)->categories;
        else
            $this->categories = Category::all();

        return view('livewire.admin.category.bubble-list', [
            'categories' => $this->categories
        ]);
    }
}
