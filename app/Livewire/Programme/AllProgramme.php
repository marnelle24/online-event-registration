<?php

namespace App\Livewire\Programme;

use Livewire\Component;
use App\Models\Programme;
use App\Models\Ministry;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Masmerise\Toaster\Toaster;

class AllProgramme extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $ministryFilter = '';
    public $typeFilter = '';
    public $perPage = 10;
    public $sortBy = 'title';
    public $sortDirection = 'asc';

    public $statuses = [
        '' => 'All Status',
        'published' => 'Published',
        'draft' => 'Draft',
        'pending' => 'Pending'
    ];

    public $types = [
        '' => 'All Types',
        'Event' => 'Event',
        'Conference' => 'Conference',
        'Workshop' => 'Workshop',
        'Seminar' => 'Seminar',
        'Retreat' => 'Retreat'
    ];

    protected $listeners = [
        'newAddedProgramme' => 'refreshProgrammes',
        'updatedProgramme' => 'refreshProgrammes'
    ];

    protected $paginationTheme = 'custom-pagination';

    public function mount()
    {
        // Initialize filters from request
        $this->sortBy = request('sortBy', 'title');
        $this->sortDirection = request('sortDirection', 'asc');
        $this->search = request('search', '');
        $this->statusFilter = request('statusFilter', '');
        $this->ministryFilter = request('ministryFilter', '');
        $this->typeFilter = request('typeFilter', '');
        $this->perPage = request('perPage', 10);
    }

    public function callEditProgrammeModal($id)
    {
        $this->dispatch('callEditProgrammeModal', $id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingMinistryFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
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

    public function sortByTitle()
    {
        $this->sortBy('title');
    }

    public function sortByMinistry()
    {
        $this->sortBy('ministry_id');
    }

    public function sortByStatus()
    {
        $this->sortBy('status');
    }

    public function sortByPrice()
    {
        $this->sortBy('price');
    }

    public function exportCsv()
    {
        $programmes = $this->getFilteredProgrammes(false); // Get all records without pagination

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="programmes_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($programmes) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Programme Code',
                'Title',
                'Ministry',
                'Type',
                'Status',
                'Start Date',
                'End Date',
                'Location',
                'Price',
                'Registrations',
                'Limit',
                'Created At',
                'Updated At'
            ]);

            foreach ($programmes as $programme) {
                fputcsv($file, [
                    $programme->programmeCode,
                    $programme->title,
                    $programme->ministry->name ?? 'N/A',
                    $programme->type,
                    $programme->status,
                    $programme->startDate,
                    $programme->endDate,
                    $programme->getLocationAttribute(),
                    $programme->formatted_price,
                    $programme->getTotalRegistrationsAttribute(),
                    $programme->limit > 0 ? $programme->limit : 'Unlimited',
                    $programme->created_at->format('Y-m-d H:i:s'),
                    $programme->updated_at->format('Y-m-d H:i:s')
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

    public function deleteProgramme($id)
    {

        $programme = Programme::find($id);

        if ($programme) 
        {
            $programme->soft_delete = true;
            $programme->save();
            Toaster::success('Programme deleted successfully!');
            \Log::info('Programme deleted successfully with id: ' . $id);
            $this->refreshProgrammes();
        }

        // $programme = Programme::find($id);
        // if ($programme) 
        // {
        //     // Check if programme has registrations
        //     if ($programme->registrations->count() > 0) {
        //         Toaster::error('Cannot delete programme. It has ' . $programme->registrations->count() . ' registration(s).');
        //         return;
        //     }
            
        //     $programme->delete();
        //     Toaster::success('Programme deleted successfully!');
        //     \Log::info('Programme deleted successfully with id: ' . $id);
        //     $this->refreshProgrammes();
        // }
        // else 
        //     Toaster::error('Programme not found!');
    }

    public function refreshProgrammes()
    {
        // Reset to first page when refreshing
        $this->resetPage();
    }

    private function getFilteredProgrammes($paginate = true)
    {
        $query = Programme::with(['ministry', 'registrations'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('programmeCode', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhere('excerpt', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'published') {
                    $query->where('status', 'published');
                } else if ($this->statusFilter === 'draft') {
                    $query->where('status', 'draft');
                } else if ($this->statusFilter === 'pending') {
                    $query->where('status', 'pending');
                }
            })
            ->when($this->ministryFilter, function ($query) {
                $query->where('ministry_id', $this->ministryFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    public function render()
    {
        $programmes = $this->getFilteredProgrammes();
        $ministries = Ministry::orderBy('name')->get();

        return view('livewire.programme.all-programme', [
            'programmes' => $programmes,
            'ministries' => $ministries
        ]);
    }
}
