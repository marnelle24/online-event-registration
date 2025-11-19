<?php

namespace App\Livewire\Admin\Registrant;

use Livewire\Component;
use App\Models\Registrant;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $programmeId;
    public $search;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function sortByName()
    {
        $this->sortBy('firstName');
    }

    public function sortByEmail()
    {
        $this->sortBy('email');
    }

    public function sortByCreatedAt()
    {
        $this->sortBy('created_at');
    }

    public function sortByNetAmount()
    {
        $this->sortBy('netAmount');
    }

    public function sortByRegStatus()
    {
        $this->sortBy('regStatus');
    }

    public function sortByPaymentStatus()
    {
        $this->sortBy('paymentStatus');
    }

    public function render()
    {
        $query = Registrant::query()
            ->where('programme_id', $this->programmeId)
            ->where('registrationType', '!=', 'individual')
            ->where('registrationType', '!=', 'group_member')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('firstName', 'like', "%{$this->search}%")
                      ->orWhere('lastName', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('confirmationCode', 'like', "%{$this->search}%");
                });
            });

        // Special handling for name sorting to sort by both firstName and lastName
        if ($this->sortBy === 'firstName') {
            $query->orderBy('firstName', $this->sortDirection)
                  ->orderBy('lastName', $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        $registrants = $query->with(['promocode', 'promotion'])
            ->paginate(10);
            
        return view('livewire.admin.registrant.index', [
            'registrants' => $registrants
        ]);
    }
}
