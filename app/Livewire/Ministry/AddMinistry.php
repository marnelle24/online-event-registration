<?php

namespace App\Livewire\Ministry;

use App\Models\Ministry;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class AddMinistry extends Component
{
    use WithFileUploads;

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

    public function resetForm()
    {
        $this->name = '';
        $this->bio = '';
        $this->contactPerson = '';
        $this->contactNumber = '';
        $this->contactEmail = '';
        $this->websiteUrl = '';
        $this->publishabled = true;
        $this->searcheable = true;
        $this->status = true;
        $this->logo = null;
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:ministries,name',
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
            $ministry = Ministry::create([
                'name' => $validatedData['name'],
                'bio' => $validatedData['bio'],
                'contactPerson' => $validatedData['contactPerson'],
                'contactNumber' => $validatedData['contactNumber'],
                'contactEmail' => $validatedData['contactEmail'],
                'websiteUrl' => $validatedData['websiteUrl'],
                'publishabled' => $validatedData['publishabled'] ?? true,
                'searcheable' => $validatedData['searcheable'] ?? true,
                'status' => $validatedData['status'] ?? true,
                'requestedBy' => auth()->user()->name ?? 'System',
                'approvedBy' => auth()->user()->role == 'admin' ? auth()->user()->name : null,
            ]);

            // Handle logo upload
            if ($this->logo) {
                $ministry->addMedia($this->logo->getRealPath())
                    ->usingFileName($this->logo->getClientOriginalName())
                    ->toMediaCollection('ministry');
            }

            sleep(1);

            if ($ministry) {
                Toaster::success('Ministry created successfully!');
                $this->resetForm();
                $this->dispatch('newAddedMinistry');
            } else {
                Toaster::error('Error creating ministry!');
            }
        } catch (\Exception $e) {
            \Log::error('Error creating ministry: ' . $e->getMessage());
            Toaster::error('Error creating ministry: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.ministry.add-ministry');
    }
}
