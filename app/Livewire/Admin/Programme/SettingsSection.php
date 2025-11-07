<?php

namespace App\Livewire\Admin\Programme;

use Livewire\Component;
use App\Models\Programme;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;

class SettingsSection extends Component
{
    public $programmeId;
    public $programme;
    public bool $invitationOnly;
    public bool $searchable;
    public bool  $publishable;
    public bool $allowPreRegistration;
    public bool $allowWalkInRegistration;
    public $externalUrl;
    public $limit;
    public $adminFee;
    public $chequeNumber;
    public $contactEmail;
    public $programmeStatus;
    public $activeUntil;
    public bool $allowBreakoutSession;
    public bool $allowGroupRegistration;
    public $groupRegistrationMin;
    public $groupRegistrationMax;
    public $groupRegistrationFee;


    public function mount()
    {
        $this->programme = Programme::find($this->programmeId);
        $this->invitationOnly = $this->programme->private_only;
        $this->searchable = $this->programme->searchable;
        $this->publishable = $this->programme->publishable;
        $this->limit = $this->programme->limit;
        $this->adminFee = $this->programme->adminFee;
        $this->chequeNumber = $this->programme->chequeCode ?? NULL;
        $this->contactEmail = $this->programme->contactEmail ?? NULL;
        $this->externalUrl = $this->programme->externalUrl ?? NULL;
        $this->activeUntil = $this->programme->activeUntil ?? NULL;
        $this->programmeStatus = $this->programme->status;
        $this->allowPreRegistration = $this->programme->allowPreRegistration;
        $this->allowBreakoutSession = $this->programme->allowBreakoutSession;
        $this->allowWalkInRegistration = $this->programme->allowWalkInRegistration;
        $this->allowGroupRegistration = $this->programme->allowGroupRegistration;
        $this->groupRegistrationMin = $this->programme->groupRegistrationMin;
        $this->groupRegistrationMax = $this->programme->groupRegistrationMax;
        $this->groupRegistrationFee = $this->programme->groupRegistrationFee;
    }

    public function toogleAllowBreakoutSession()
    {
        $isUpdated = $this->programme->update(['allowBreakoutSession' => $this->allowBreakoutSession]);
        if($isUpdated)
        {
            $msg = $this->allowBreakoutSession ? 
                'Breakout session is now enabled.' : 
                'Breakout session is now disabled.';
            Toaster::success($msg);
        }
        else
            Toaster::error('Something\'s wrong, please try again later.');
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
            Toaster::error('Something\'s wrong, please try again later.');
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
            Toaster::error('Something\'s wrong, please try again later.');
    }

    // Toogle for Allow Pre-registration
    public function toogleAllowPreRegistration()
    {
        $isUpdated = $this->programme->update(['allowPreRegistration' => $this->allowPreRegistration]);
        if($isUpdated)
        {
            $msg = $this->allowPreRegistration ? 
                'Programme is now allowed for pre-registration.' : 
                'Programme is not allowed for pre-registration.';
            Toaster::success($msg);
        }
        else
            Toaster::error('Something\'s wrong, please try again later.');
    }

    // Toogle for Allow Group Registration
    public function toogleAllowGroupRegistration()
    {
        $this->allowGroupRegistration = !$this->allowGroupRegistration;
        $isUpdated = $this->programme->update(['allowGroupRegistration' => $this->allowGroupRegistration]);
        if($isUpdated)
            Toaster::success($this->allowGroupRegistration ? 
                'Group registration is now enabled.' : 
                'Group registration is now disabled.');
        else
            Toaster::error('Something\'s wrong, please try again later.');
    }

    //toogle for allow group registration
    public function saveGroupRegistrationSettings()
    {
        $validator = Validator::make([
            'groupRegistrationMin' => $this->groupRegistrationMin,
            'groupRegistrationMax' => $this->groupRegistrationMax,
            'groupRegistrationFee' => $this->groupRegistrationFee
        ], [
            'groupRegistrationMin' => 'required|integer|min:1',
            'groupRegistrationMax' => 'required|integer|min:1|gte:groupRegistrationMin',
            'groupRegistrationFee' => 'nullable|numeric|min:0'
        ]);

        if($validator->fails())
        {
            foreach($validator->errors()->all() as $error)
            {
                Toaster::error($error);
            }
            return;
        }

        $isUpdated = $this->programme->update([
            'groupRegistrationMin' => $this->groupRegistrationMin, 
            'groupRegistrationMax' => $this->groupRegistrationMax, 
            'groupRegistrationFee' => $this->groupRegistrationFee
        ]);

        if($isUpdated)
            Toaster::success('Group registration settings updated successfully.');
        else
            Toaster::error('Something\'s wrong, please try again later.');
    }

    //toogle for allow walkin registration
    public function toogleAllowWalkInRegistration()
    {
        $isUpdated = $this->programme->update(['allowWalkInRegistration' => $this->allowWalkInRegistration]);
        if($isUpdated)
        {
            $msg = $this->allowWalkInRegistration ? 
                'Programme is now allowed for walk in registration.' : 
                'Programme is not allowed for walk in registration.';
            Toaster::success($msg);
        }
        else
            Toaster::error('Something\'s wrong, please try again later.');
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
            Toaster::error('Something\'s wrong, please try again later.');
    }

    public function updateProgrammeInfo($colName, $model)
    {
        // dump($colName, $model);
        $isUpdated = $this->programme->update([$colName => $model]);
        if($isUpdated)
            Toaster::success('Programme information changed successfully.');
        else
            Toaster::error('Something\'s wrong, please try again later.');

        $this->render();
    }


    public function confirmedStatusChange()
    {
        $isUpdated = $this->programme->update(['status' => $this->programmeStatus]);
        if($isUpdated)
            Toaster::success('Programme status has been updated.');
        else
            Toaster::error('Something\'s wrong, please try again later.');
    }
    
    public function render()
    {
        return view('livewire.admin.programme.settings-section');
    }
}
