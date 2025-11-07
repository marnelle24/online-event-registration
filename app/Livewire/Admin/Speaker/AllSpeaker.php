<?php

namespace App\Livewire\Admin\Speaker;

use Livewire\Component;
use App\Models\Speaker;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Masmerise\Toaster\Toaster;

class AllSpeaker extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    public $professionFilter = '';
    public $perPage = 10;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    protected $listeners = [
        'newAddedSpeaker' => 'refreshSpeakers',
        'updatedSpeaker' => 'refreshSpeakers'
    ];
    
    protected $paginationTheme = 'custom-pagination';

    public function mount()
    {
        // Handle initial state from URL parameters if needed
        $this->sortBy = request('sortBy', 'name');
        $this->sortDirection = request('sortDirection', 'asc');
        $this->search = request('search', '');
        $this->statusFilter = request('statusFilter', '');
        $this->professionFilter = request('professionFilter', '');
        $this->perPage = request('perPage', 10);
    }

    public function callEditSpeakerModal($id)
    {
        $this->dispatch('callEditSpeakerModal', $id)->to('admin.speaker.edit-speaker');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingProfessionFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
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

    public function sortByField($field)
    {
        $this->sortBy($field);
    }

    public function sortByName()
    {
        $this->sortBy('name');
    }

    public function sortByEmail()
    {
        $this->sortBy('email');
    }

    public function sortByProfession()
    {
        $this->sortBy('profession');
    }

    public function sortByStatus()
    {
        $this->sortBy('is_active');
    }

    public function sortByCreatedAt()
    {
        $this->sortBy('created_at');
    }

    public function exportCsv()
    {
        $speakers = $this->getFilteredSpeakers(false); // Get all records without pagination
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="speakers_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($speakers) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Name',
                'Title',
                'Email',
                'Profession',
                'Status',
                'Created At',
                'Updated At'
            ]);

            foreach ($speakers as $speaker) {
                fputcsv($file, [
                    $speaker->name,
                    $speaker->title,
                    $speaker->email,
                    $speaker->profession,
                    $speaker->is_active ? 'Active' : 'Inactive',
                    $speaker->created_at->format('Y-m-d H:i:s'),
                    $speaker->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportExcel()
    {
        // For Excel export, you might want to use a package like Laravel Excel
        // For now, we'll return a CSV with .xlsx extension
        return $this->exportCsv();
    }

    public function toggleStatus($id)
    {
        $speaker = Speaker::find($id);
        if ($speaker) 
        {
            $speaker->is_active = !$speaker->is_active;
            $speaker->save();
            $message = $speaker->is_active ? 'Speaker enabled successfully!' : 'Speaker disabled successfully!';
            Toaster::success($message);
            \Log::info('Speaker ' . $speaker->is_active ? 'enabled' : 'disabled' . ' successfully with id: ' . $id);
            $this->refreshSpeakers();
        }
        else 
            Toaster::error('Speaker not found!');

        // if ($speaker) {
        //     $speaker->clearMediaCollection('speaker');
        //     $speaker->delete();
        //     Toaster::success('Speaker deleted successfully!');
        //     \Log::info('Speaker deleted successfully with id: ' . $id);
        //     $this->refreshSpeakers();
        // } else {
        //     Toaster::error('Speaker not found!');
        // }
    }

    public function refreshSpeakers()
    {
        // Reset to first page when refreshing
        $this->resetPage();
    }

    private function getFilteredSpeakers($paginate = true)
    {
        $query = Speaker::query()
            // ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('profession', 'like', "%{$this->search}%")
                        ->orWhere('title', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->when($this->professionFilter, function ($query) {
                $query->where('profession', 'like', "%{$this->professionFilter}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    public function render()
    {
        $speakers = $this->getFilteredSpeakers();
        $professions = Speaker::distinct()
            ->whereNotNull('profession')
            ->where('profession', '!=', '')
            ->pluck('profession')
            ->sort()
            ->values();
        
        return view('livewire.admin.speaker.all-speaker', [
            'speakers' => $speakers,
            'professions' => $professions
        ]);
    }
}
