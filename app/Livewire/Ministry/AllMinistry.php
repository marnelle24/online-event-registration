<?php

namespace App\Livewire\Ministry;

use Livewire\Component;
use App\Models\Ministry;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Masmerise\Toaster\Toaster;

class AllMinistry extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    protected $listeners = [
        'newAddedMinistry' => 'refreshMinistries',
        'updatedMinistry' => 'refreshMinistries'
    ];

    protected $paginationTheme = 'custom-pagination';

    public function mount()
    {
        // Initialize filters from request
        $this->sortBy = request('sortBy', 'name');
        $this->sortDirection = request('sortDirection', 'asc');
        $this->search = request('search', '');
        $this->statusFilter = request('statusFilter', '');
        $this->perPage = request('perPage', 10);
    }

    public function callEditMinistryModal($id)
    {
        $this->dispatch('callEditMinistryModal', $id);
    }

    public function callManageUsersModal($id)
    {
        $this->dispatch('callManageUsersModal', $id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
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

    public function sortByName()
    {
        $this->sortBy('name');
    }

    public function sortByDescription()
    {
        $this->sortBy('bio');
    }

    public function sortByStatus()
    {
        $this->sortBy('status');
    }

    public function sortByCreatedAt()
    {
        $this->sortBy('created_at');
    }

    public function exportCsv()
    {
        $ministries = $this->getFilteredMinistries(false); // Get all records without pagination

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ministries_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($ministries) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Name',
                'Bio',
                'Status',
                'Created At',
                'Updated At'
            ]);

            foreach ($ministries as $ministry) {
                fputcsv($file, [
                    $ministry->name,
                    $ministry->bio,
                    $ministry->status ? 'Active' : 'Inactive',
                    $ministry->created_at->format('Y-m-d H:i:s'),
                    $ministry->updated_at->format('Y-m-d H:i:s')
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

    public function changeBooleanStatus($id, $field)
    {
        $ministry = Ministry::find($id);
        if ($ministry) 
        {
            $ministry->$field = !$ministry->$field;
            $ministry->save();
            
            $fieldLabels = [
                'status' => 'Status',
                'publishabled' => 'Publishable',
                'searcheable' => 'Searchable'
            ];
            
            $fieldLabel = $fieldLabels[$field] ?? ucfirst($field);
            $message = $ministry->$field ? "{$fieldLabel} enabled successfully!" : "{$fieldLabel} disabled successfully!";
            Toaster::success($message);
            \Log::info("Ministry {$fieldLabel} " . ($ministry->$field ? 'enabled' : 'disabled') . " successfully with id: " . $id);
            $this->refreshMinistries();
        }
        else 
            Toaster::error('Ministry not found!');
    }

    public function refreshMinistries()
    {
        // Reset to first page when refreshing
        $this->resetPage();
    }

    private function getFilteredMinistries($paginate = true)
    {
        $query = Ministry::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('bio', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'active')
                    $query->where('status', 1);
                elseif ($this->statusFilter === 'inactive')
                    $query->where('status', 0);
                elseif ($this->statusFilter === 'publishabled')
                    $query->where('publishabled', 1);
                elseif ($this->statusFilter === 'searcheable')
                    $query->where('searcheable', 1);
                elseif ($this->statusFilter === 'not publishable')
                    $query->where('publishabled', 0);
                elseif ($this->statusFilter === 'not searcheable')
                    $query->where('searcheable', 0);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    public function render()
    {
        $ministries = $this->getFilteredMinistries();

        return view('livewire.ministry.all-ministry', [
            'ministries' => $ministries
        ]);
    }
}
