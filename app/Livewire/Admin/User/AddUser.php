<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\Ministry;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Masmerise\Toaster\Toaster;

class AddUser extends Component
{
    public $name = '';
    public $email = '';
    public $firstname = '';
    public $lastname = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';
    public $is_active = true;
    public $ministries = [];
    public $ministrySearch = '';
    public $show = false;
    public $selectAllMinistries = false;

    protected $listeners = [
        'callAddUserModal' => 'openModal',
    ];

    public function openModal()
    {
        $this->show = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'user';
        $this->is_active = true;
        $this->ministries = [];
        $this->ministrySearch = '';
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user',
            'is_active' => 'boolean',
            'ministries' => 'nullable|array',
            'ministries.*' => 'exists:ministries,id',
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'role.required' => 'Role is required.',
            'role.in' => 'Role must be either admin or user.',
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'firstname' => $validatedData['firstname'] ?? null,
                'lastname' => $validatedData['lastname'] ?? null,
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'is_active' => $validatedData['is_active'] ?? true,
            ]);

            // Attach ministries if provided
            if (!empty($this->ministries)) {
                $user->ministries()->attach($this->ministries);
            }

            sleep(1);

            if ($user) {
                Toaster::success('User created successfully!');
                $this->resetForm();
                $this->dispatch('newAddedUser');
                $this->dispatch('close-modal');
            } 
            else {
                Toaster::error('Error creating user!');
            }
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            Toaster::error('Error creating user: ' . $e->getMessage());
        }
    }
    public function selectAllMinistriesCheckbox()
    {
        if($this->selectAllMinistries)
            $this->ministries = Ministry::orderBy('name')->get()->pluck('id')->toArray();
        else
            $this->ministries = [];
    }

    public function render()
    {
        $allMinistries = Ministry::when($this->ministrySearch, function ($query) {
                $query->where('name', 'like', '%' . $this->ministrySearch . '%');
            })
            ->orderBy('name')
            ->get();
        
        return view('livewire.admin.user.add-user', [
            'allMinistries' => $allMinistries
        ]);
    }
}

