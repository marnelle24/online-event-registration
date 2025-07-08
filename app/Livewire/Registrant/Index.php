<?php

namespace App\Livewire\Registrant;

use Livewire\Component;
use App\Models\Registrant;

class Index extends Component
{
    public $programmeId;
    public $search;

    public function render()
    {
        $registrants = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
                $query->orWhere('email', 'like', "%{$this->search}%");
            })
            ->latest('created_at')
            ->get();
        return view('livewire.registrant.index', [
            'registrants' => $registrants
        ]);
    }
}
