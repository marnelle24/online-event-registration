<?php

namespace App\Livewire\Admin\Ministry;

use App\Models\Ministry;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditMinistry extends Component
{
    use WithFileUploads;

    public $ministry;
    public $name;
    public $bio;
    public $contactPerson;
    public $contactNumber;
    public $contactEmail;
    public $websiteUrl;
    public $publishabled = true;
    public $searcheable = true;
    public $status = true;
    public $logo;
    public $show = false;
    public $loading = false;

    protected $listeners = [
        'callEditMinistryModal' => 'openModal',
    ];

    public function getMinistryData($ministryId)
    {
        $this->ministry = Ministry::find($ministryId);
        
        if (!$this->ministry) {
            throw new \Exception('Ministry not found');
        }

        // Populate form fields with existing data
        $this->name = $this->ministry->name;
        $this->bio = $this->ministry->bio;
        $this->contactPerson = $this->ministry->contactPerson;
        $this->contactNumber = $this->ministry->contactNumber;
        $this->contactEmail = $this->ministry->contactEmail;
        $this->websiteUrl = $this->ministry->websiteUrl;
        $this->publishabled = $this->ministry->publishabled;
        $this->searcheable = $this->ministry->searcheable;
        $this->status = $this->ministry->status;
    }

    public function openModal($id)
    {
        $this->loading = true;
        $this->show = true;
        
        try {
            $this->getMinistryData($id);
            $this->loading = false;
        } catch (\Exception $e) {
            $this->loading = false;
            $this->show = false;
            Toaster::error('Error loading ministry data: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function resetForm()
    {
        if ($this->ministry) {
            $this->name = $this->ministry->name;
            $this->bio = $this->ministry->bio;
            $this->contactPerson = $this->ministry->contactPerson;
            $this->contactNumber = $this->ministry->contactNumber;
            $this->contactEmail = $this->ministry->contactEmail;
            $this->websiteUrl = $this->ministry->websiteUrl;
            $this->publishabled = $this->ministry->publishabled;
            $this->searcheable = $this->ministry->searcheable;
            $this->status = $this->ministry->status;
            $this->logo = null;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:ministries,name,' . $this->ministry->id,
            'bio' => 'nullable|string',
            'contactPerson' => 'required|string|max:255',
            'contactNumber' => 'nullable|string|max:20',
            'contactEmail' => 'nullable|email|max:255',
            'websiteUrl' => 'nullable|url|max:255',
            'publishabled' => 'nullable|boolean',
            'searcheable' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'logo' => 'nullable|image|max:2024|mimes:png,jpg,jpeg',
        ], [
            'name.required' => 'Ministry name is required.',
            'name.unique' => 'A ministry with this name already exists.',
            'contactPerson.required' => 'Contact person is required.',
            'contactEmail.email' => 'Please provide a valid email address.',
            'websiteUrl.url' => 'Please provide a valid website URL.',
            'logo.image' => 'The logo must be an image file.',
            'logo.max' => 'The logo may not be greater than 2MB.',
        ]);

        try {
            $updated = $this->ministry->update([
                'name' => $validatedData['name'],
                'bio' => $validatedData['bio'],
                'contactPerson' => $validatedData['contactPerson'],
                'contactNumber' => $validatedData['contactNumber'],
                'contactEmail' => $validatedData['contactEmail'],
                'websiteUrl' => $validatedData['websiteUrl'],
                'publishabled' => $validatedData['publishabled'] ?? true,
                'searcheable' => $validatedData['searcheable'] ?? true,
                'status' => $validatedData['status'] ?? true,
            ]);

            // Handle logo upload
            if ($this->logo) {
                // Clear existing media first
                $this->ministry->clearMediaCollection('ministry');
                // Add new media
                $this->ministry->addMedia($this->logo->getRealPath())
                    ->usingFileName($this->logo->getClientOriginalName())
                    ->toMediaCollection('ministry');
            }

            sleep(1);

            if ($updated) {
                Toaster::success('Ministry updated successfully!');
                $this->show = false;
                $this->dispatch('updatedMinistry');
            } else {
                Toaster::error('Error updating ministry!');
            }
        } catch (\Exception $e) {
            \Log::error('Error updating ministry: ' . $e->getMessage());
            Toaster::error('Error updating ministry: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.ministry.edit-ministry');
    }
}
