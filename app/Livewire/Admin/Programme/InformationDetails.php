<?php

namespace App\Livewire\Admin\Programme;

use Livewire\Component;
use App\Models\Programme;

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
    }

    public function toogleShowEditDescription()
    {
        $this->showEditDescription = !$this->showEditDescription;
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
