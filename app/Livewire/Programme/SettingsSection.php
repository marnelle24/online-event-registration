<?php

namespace App\Livewire\Programme;

use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;

class SettingsSection extends Component
{
    public $programmeId;
    public $programme;
    public bool $invitationOnly;
    public bool $searchable;
    public bool  $publishable;
    public string $externalUrl;
    public int $limit;
    public $adminFee;
    public $chequeNumber;
    public string $contactEmail;
    public string $programmeStatus;
    public $activeUntil;

    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
        $this->invitationOnly = $this->programme->private_only;
        $this->searchable = $this->programme->searchable;
        $this->publishable = $this->programme->publishable;
        $this->limit = $this->programme->limit;
        $this->adminFee = $this->programme->adminFee;
        $this->chequeNumber = $this->programme->chequeCode;
        $this->contactEmail = $this->programme->contactEmail;
        $this->externalUrl = $this->programme->externalUrl;
        $this->activeUntil = $this->programme->activeUntil;
        $this->programmeStatus = $this->programme->status;
    }

    // Toggle for Invitation Only Mode
    public function toogleInvitationOnly()
    {
        $isUpdated = $this->programme->update(['private_only' => $this->invitationOnly]);
        if($isUpdated)
        {
            $msg = $this->invitationOnly ? 
                'Programme set to invitation mode successfully.' : 
                'Programme set to public mode successfully.';
            Toaster::success($msg);
        }
        else
            Toaster::danger('Something\'s wrong, please try again later.');
    }

    // Toogle for Searchable Mode
    public function toogleSearchable()
    {
        $isUpdated = $this->programme->update(['searchable' => $this->searchable]);
        if($isUpdated)
        {
            $msg = $this->searchable ? 
                'Programme is now searchable in the system.' : 
                'Programme is not searchable in the search engine.';
            Toaster::success($msg);
        }
        else
            Toaster::danger('Something\'s wrong, please try again later.');
    }
    
    // Toogle for Publishable Mode
    public function tooglePublishable()
    {
        $isUpdated = $this->programme->update(['publishable' => $this->publishable]);
        if($isUpdated)
        {
            $msg = $this->publishable ? 
                'Programme is now publishable in the system.' : 
                'Programme is not publishable but still searchable in the search engine.';
            Toaster::success($msg);
        }
        else
            Toaster::danger('Something\'s wrong, please try again later.');
    }

    public function updateProgrammeInfo($colName, $model)
    {
        // dump($colName, $model);
        $isUpdated = $this->programme->update([$colName => $model]);
        if($isUpdated)
            Toaster::success('Programme information changed successfully.');
        else
            Toaster::danger('Something\'s wrong, please try again later.');

        $this->render();
    }


    public function confirmedStatusChange()
    {
        $isUpdated = $this->programme->update(['status' => $this->programmeStatus]);
        if($isUpdated)
            Toaster::success('Programme status has been updated.');
        else
            Toaster::danger('Something\'s wrong, please try again later.');
    }
    
    public function render()
    {
        return view('livewire.programme.settings-section');
    }
}
