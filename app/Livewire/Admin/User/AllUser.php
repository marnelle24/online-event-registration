<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Ministry;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Masmerise\Toaster\Toaster;

class AllUser extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $ministryFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public $roles = [
        '' => 'All Roles',
        'admin' => 'Admin',
        'user' => 'User',
    ];

    public $statuses = [
        '' => 'All Status',
        '1' => 'Active',
        '0' => 'Inactive',
    ];

    protected $listeners = [
        'newAddedUser' => 'refreshUsers',
        'updatedUser' => 'refreshUsers'
    ];

    protected $paginationTheme = 'custom-pagination';

    public function mount()
    {
        // Initialize filters from request
        $this->sortBy = request('sortBy', 'name');
        $this->sortDirection = request('sortDirection', 'asc');
        $this->search = request('search', '');
        $this->roleFilter = request('roleFilter', '');
        $this->ministryFilter = request('ministryFilter', '');
        $this->statusFilter = request('statusFilter', '');
        $this->perPage = request('perPage', 10);
    }

    public function callEditUserModal($id)
    {
        $this->dispatch('callEditUserModal', $id);
    }

    public function callResetPasswordModal($id)
    {
        $this->dispatch('callResetPasswordModal', $id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingMinistryFilter()
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

    public function sortByName()
    {
        $this->sortBy('name');
    }

    public function sortByEmail()
    {
        $this->sortBy('email');
    }

    public function sortByRole()
    {
        $this->sortBy('role');
    }

    public function sortByStatus()
    {
        $this->sortBy('is_active');
    }

    public function exportCsv()
    {
        $users = $this->getFilteredUsers(false); // Get all records without pagination

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Name',
                'Email',
                'First Name',
                'Last Name',
                'Role',
                'Status',
                'Ministries',
                'Created At',
                'Updated At'
            ]);

            foreach ($users as $user) {
                $ministries = $user->ministries->pluck('name')->join(', ');
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->firstname ?? 'N/A',
                    $user->lastname ?? 'N/A',
                    $user->role,
                    $user->is_active ? 'Active' : 'Inactive',
                    $ministries ?: 'N/A',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->updated_at->format('Y-m-d H:i:s')
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

    public function toggleUserStatus($id)
    {
        $user = User::find($id);

        if ($user) 
        {
            // Don't allow deactivating yourself
            if ($user->id === auth()->id() && $user->is_active) {
                Toaster::error('You cannot deactivate your own account!');
                return;
            }

            $user->is_active = !$user->is_active;
            $user->save();
            
            $statusText = $user->is_active ? 'activated' : 'deactivated';
            Toaster::success("User {$statusText} successfully!");
            \Log::info("User status toggled - ID: {$id}, Status: " . ($user->is_active ? 'Active' : 'Inactive'));
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) 
        {
            // Don't allow deleting yourself
            if ($user->id === auth()->id()) {
                Toaster::error('You cannot delete your own account!');
                return;
            }

            $user->delete();
            Toaster::success('User deleted successfully!');
            \Log::info('User deleted successfully with id: ' . $id);
            $this->refreshUsers();
        }
    }

    public function refreshUsers()
    {
        // Reset to first page when refreshing
        $this->resetPage();

        $this->render();
    }

    private function getFilteredUsers($paginate = true)
    {
        $query = User::with('ministries')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('firstname', 'like', "%{$this->search}%")
                        ->orWhere('lastname', 'like', "%{$this->search}%");
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->when($this->ministryFilter, function ($query) {
                $query->whereHas('ministries', function ($q) {
                    $q->where('ministries.id', $this->ministryFilter);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    public function render()
    {
        $users = $this->getFilteredUsers();
        $ministries = Ministry::orderBy('name')->get();

        return view('livewire.admin.user.all-user', [
            'users' => $users,
            'ministries' => $ministries
        ]);
    }
}

