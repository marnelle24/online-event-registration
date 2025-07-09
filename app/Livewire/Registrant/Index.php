<?php

namespace App\Livewire\Registrant;

use Livewire\Component;
use App\Models\Registrant;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $programmeId;
    public $search;

    public function render()
    {
        $registrants = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->when($this->search, function ($query) {
                $query->where('firstName', 'like', "%{$this->search}%");
                $query->orWhere('lastName', 'like', "%{$this->search}%");
                $query->orWhere('email', 'like', "%{$this->search}%");
            })
            ->latest('created_at')
            ->paginate(2);
        return view('livewire.registrant.index', [
            'registrants' => $registrants
        ]);
    }
}
