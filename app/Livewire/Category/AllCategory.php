<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Masmerise\Toaster\Toaster;

class AllCategory extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    protected $listeners = [
        'newAddedCategory' => 'refreshCategories',
        'updatedCategory' => 'refreshCategories'
    ];

    protected $paginationTheme = 'custom-pagination';

    public function mount()
    {
        // Initialize filters from request
        $this->sortBy = request('sortBy', 'name');
        $this->sortDirection = request('sortDirection', 'asc');
        $this->search = request('search', '');
        $this->perPage = request('perPage', 10);
    }

    public function callEditCategoryModal($id)
    {
        $this->dispatch('callEditCategoryModal', $id);
    }

    public function updatingSearch()
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

    public function sortByCreatedAt()
    {
        $this->sortBy('created_at');
    }

    public function exportCsv()
    {
        $categories = $this->getFilteredCategories(false); // Get all records without pagination

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="categories_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Name',
                'Slug',
                'Programmes Count',
                'Created At',
                'Updated At'
            ]);

            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->name,
                    $category->slug,
                    $category->programmes->count(),
                    $category->created_at->format('Y-m-d H:i:s'),
                    $category->updated_at->format('Y-m-d H:i:s')
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

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) 
        {
            // Check if category has programmes
            if ($category->programmes->count() > 0) {
                Toaster::error('Cannot delete category. It is assigned to ' . $category->programmes->count() . ' programme(s).');
                return;
            }
            
            $category->delete();
            Toaster::success('Category deleted successfully!');
            \Log::info('Category deleted successfully with id: ' . $id);
            $this->refreshCategories();
        }
        else 
            Toaster::error('Category not found!');
    }

    public function refreshCategories()
    {
        // Reset to first page when refreshing
        $this->resetPage();
    }

    private function getFilteredCategories($paginate = true)
    {
        $query = Category::with('programmes')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    public function render()
    {
        $categories = $this->getFilteredCategories();

        return view('livewire.category.all-category', [
            'categories' => $categories
        ]);
    }
}
