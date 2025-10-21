<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Registrant;

class RegistrantDetails extends Component
{
    public $registrantId;
    public $registrant;
    public $showModal = false;

    protected $listeners = ['show-registrant-details' => 'showDetails'];

    // public function mount()
    // {
    //     $this->registrantId = 17;
    //     $this->showDetails(17);
    // }

    public function showDetails($registrantId)
    {
        $this->registrantId = $registrantId;
        $this->registrant = Registrant::with([
            'programme.ministry', 
            'programme.categories', 
            'promocode', 
            'promotion'
        ])->find($registrantId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->registrant = null;
        $this->registrantId = null;
    }

    public function render()
    {
        return view('livewire.admin.registrant-details');
    }
}
