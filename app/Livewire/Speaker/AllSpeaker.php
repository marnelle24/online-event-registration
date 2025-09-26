<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class AllSpeaker extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $listeners = [
        'newAddedSpeaker' => 'refreshSpeakers',
        'updatedSpeaker' => 'refreshSpeakers'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function deleteSpeaker($id)
    {
        $speaker = Speaker::find($id);
        if ($speaker) {
            // Delete associated media if any
            $speaker->clearMediaCollection('speaker');
            $speaker->delete();
            Toaster::success('Speaker deleted successfully!');
            \Log::info('Speaker deleted successfully with id: ' . $id);
            $this->refreshSpeakers();
        } else {
            Toaster::error('Speaker not found!');
        }
    }

    public function refreshSpeakers()
    {
        // Reset to first page when refreshing
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }
    
    public function render()
    {
        $speakers = Speaker::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('profession', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('title', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.speaker.all-speaker', [
            'speakers' => $speakers
        ]);
    }
}
