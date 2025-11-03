<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\Ministry;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Masmerise\Toaster\Toaster;

class EditUser extends Component
{
    public $user;
    public $name;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $password_confirmation;
    public $role;
    public $is_active;
    public $ministries = [];
    public $ministrySearch = '';
    public $show = false;
    public $loading = false;

    protected $listeners = [
        'callEditUserModal' => 'openModal',
    ];

    public function getUserData($userId)
    {
        $this->user = User::with('ministries')->find($userId);
        
        if (!$this->user) {
            throw new \Exception('User not found');
        }

        // Populate form fields with existing data
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->firstname = $this->user->firstname;
        $this->lastname = $this->user->lastname;
        $this->role = $this->user->role;
        $this->is_active = $this->user->is_active;
        $this->ministries = $this->user->ministries->pluck('id')->toArray();
    }

    public function openModal($id)
    {
        $this->loading = true;
        $this->show = true;
        
        try {
            $this->getUserData($id);
            $this->loading = false;
        } catch (\Exception $e) {
            $this->loading = false;
            $this->show = false;
            Toaster::error('Error loading user data: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->user = null;
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

    public function update()
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id . '|max:255',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'role' => 'required|string|in:admin,user',
            'is_active' => 'boolean',
            'ministries' => 'nullable|array',
            'ministries.*' => 'exists:ministries,id',
        ];

        $validationMessages = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'role.required' => 'Role is required.',
            'role.in' => 'Role must be either admin or user.',
        ];

        // Only validate password if it's provided
        if ($this->password) {
            $validationRules['password'] = 'required|string|min:8|confirmed';
            $validationMessages['password.required'] = 'Password is required.';
            $validationMessages['password.min'] = 'Password must be at least 8 characters.';
            $validationMessages['password.confirmed'] = 'Password confirmation does not match.';
        }

        $validatedData = $this->validate($validationRules, $validationMessages);

        try {
            $updateData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'firstname' => $validatedData['firstname'] ?? null,
                'lastname' => $validatedData['lastname'] ?? null,
                'role' => $validatedData['role'],
                'is_active' => $validatedData['is_active'] ?? true,
            ];

            // Only update password if provided
            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($validatedData['password']);
            }

            $this->user->update($updateData);

            // Sync ministries
            $this->user->ministries()->sync($this->ministries ?? []);

            sleep(1);

            Toaster::success('User updated successfully!');
            $this->resetForm();
            $this->show = false;
            $this->dispatch('updatedUser');
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            Toaster::error('Error updating user: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $allMinistries = Ministry::when($this->ministrySearch, function ($query) {
                $query->where('name', 'like', '%' . $this->ministrySearch . '%');
            })
            ->orderBy('name')
            ->get();
        
        return view('livewire.admin.user.edit-user', [
            'allMinistries' => $allMinistries
        ]);
    }
}

