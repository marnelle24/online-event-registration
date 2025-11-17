<?php

namespace App\Livewire\Admin\Programme;

use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class InformationDetails extends Component
{
    public $programmeId;
    public $programme;
    public $excerpt;
    public $showEdit = false;
    public $showEditDescription = false;
    public $description;

    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
        $this->excerpt = $this->programme->excerpt;
        $this->description = $this->programme->description;
    }

    public function toogleShowEdit()
    {
        $this->showEdit = !$this->showEdit;
        $this->excerpt = $this->programme->excerpt;
    }

    public function toogleShowEditDescription()
    {
        $this->showEditDescription = !$this->showEditDescription;
        $this->description = $this->programme->description;
    }

    public function updateExcerpt()
    {
        $this->programme->update([
            'excerpt' => $this->excerpt
        ]);
        
        $this->showEdit = false;
        $this->programme->refresh();
        
        Toaster::success('Excerpt updated successfully.');
    }

    public function updateDescription()
    {
        $this->programme->update([
            'description' => $this->description
        ]);
        
        $this->showEditDescription = false;
        $this->programme->refresh();
        
        Toaster::success('Description updated successfully.');
    }

    public function updatedProgramme($value)
    {
        $this->programme = $value;
    }

    public function render()
    {
        return view('livewire.admin.programme.information-details');
    }
}
