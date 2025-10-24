<?php

namespace App\Livewire\Ministry;

use App\Models\User;
use Livewire\Component;
use App\Models\Ministry;
use Masmerise\Toaster\Toaster;

class ManageUsersModal extends Component
{
    public $ministry;
    public $show = false;
    public $loading = false;
    public $search = '';
    public $users = [];

    protected $listeners = [
        'callManageUsersModal' => 'openModal',
    ];

    public function getMinistryData($ministryId)
    {
        $this->ministry = Ministry::with('users')->where('name', 'like', '%'.$this->search.'%')->find($ministryId);
        
        if (!$this->ministry) {
            throw new \Exception('Ministry not found');
        }
    }

    public function getAllUsers()
    {
        $this->users = User::where('name', 'like', '%'.$this->search.'%')->get();
    }

    public function openModal($id)
    {
        $this->loading = true;
        $this->show = true;
        
        try 
        {
            $this->getMinistryData($id);
            $this->getAllUsers();
            $this->loading = false;
        } 
        catch (\Exception $e) 
        {
            $this->loading = false;
            $this->show = false;
            session()->flash('error', 'Error loading ministry data: ' . $e->getMessage());
        }
    }

    public function addUserToMinistry($userId)
    {
        $this->ministry->users()->attach($userId);
        $this->getAllUsers();
        Toaster::success('User added to ministry');
    }

    public function detachUserFromMinistry($userId)
    {
        $this->ministry->users()->detach($userId);
        $this->getAllUsers();
        Toaster::success('User removed from ministry');
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.ministry.manage-users-modal');
    }
}
