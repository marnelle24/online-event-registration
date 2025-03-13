<?php

namespace App\Livewire\Ministry;

use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\DB;

class AddUserToMinistry extends Component
{
    public $ministry;
    public $search = '';
    public $users = [];

    public function mount($ministry)
    {
        $this->ministry = $ministry;
    }

    public function addUserToMinistry($userId)
    {
        try 
        {
            $ministryUser = DB::table('ministry_user')->where('user_id', $userId)->where('ministry_id', $this->ministry->id)->first();
            if (!$ministryUser) 
            {
                $this->ministry->users()->attach($userId);
                $this->users = $this->ministry->users;
                $this->search = '';
                $this->users = [];
                Toaster::success('User added to ministry');
            }
            else
                Toaster::error('User already in ministry');
        } 
        catch (\Exception $e) 
        {
            Toaster::error('Failed to add user to ministry');
        }
        
    }

    public function detachUserToMinistry($userId)
    {
        try
        {
            $this->ministry->users()->detach($userId);
            $this->users = $this->ministry->users;
            Toaster::success('User removed from ministry');
        }
        catch (\Exception $e)
        {
            Toaster::error('Failed to remove user from ministry');
        }
    }

    public function render()
    {
        $this->users = User::where('name', 'like', '%' . $this->search . '%')->get();
        return view('livewire.ministry.add-user-to-ministry', [
            'users' => $this->users
        ]);
    }
}
