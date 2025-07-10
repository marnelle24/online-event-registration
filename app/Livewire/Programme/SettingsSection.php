<?php

namespace App\Livewire\Programme;

use Livewire\Component;

class SettingsSection extends Component
{
    public $invitationOnly = false;
    public $searchable = false;
    public $publishable = false;
    public $programmeStatus = 'published';
    
    public function render()
    {
        return view('livewire.programme.settings-section');
    }
}
