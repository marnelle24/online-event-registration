<?php

namespace App\Livewire\Admin\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class AddSpeaker extends Component
{
    use WithFileUploads;

    public $title = 'Mr';
    public $name;
    public $profession;
    public $email;
    public $about;
    public $socials = [
        ['platform' => '', 'url' => ''],
    ];
    public $is_active = true;
    public $thumbnail;

    public function addSocMedAccount()
    {
        $this->socials[] = ['platform' => '', 'url' => ''];
    }

    public function removeSocMedAccount($index)
    {
        unset($this->socials[$index]);
        $this->socials = array_values($this->socials);
    }

    public function save()
    {
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'about' => 'nullable|string',
            'socials.*.platform' => 'nullable|string|max:255',
            'socials.*.url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
            'thumbnail' => 'nullable|image|max:2024|mimes:png,jpg,jpeg',
        ], [
            'title.required' => 'Title is required.',
            'name.required' => 'Name is required.',
            'profession.required' => 'Profession is required.',
            'email.email' => 'Please provide a valid email address.',
            'socials.*.url.url' => 'Please provide a valid URL for the social media account.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'thumbnail.max' => 'The thumbnail may not be greater than 2MB.',
        ]);

        try {
            // Remove empty social media accounts
            foreach ($validatedData['socials'] as $key => $social) {
                if (empty($social['platform']) || empty($social['url'])) {
                    unset($validatedData['socials'][$key]);
                }
            }

            // Reindex the array to remove gaps
            $validatedData['socials'] = array_values($validatedData['socials']);
            
            // Convert socials to JSON
            $socials = count($validatedData['socials']) > 0 ? json_encode($validatedData['socials']) : null;
            
            $speaker = Speaker::create([
                'title' => $validatedData['title'],
                'name' => $validatedData['name'],
                'profession' => $validatedData['profession'],
                'email' => $validatedData['email'],
                'about' => $validatedData['about'],
                'socials' => $socials,
                'is_active' => $validatedData['is_active'] ?? true,
            ]);
            
            // Handle thumbnail upload
            if ($this->thumbnail) {
                $speaker->addMedia($this->thumbnail->getRealPath())
                    ->usingFileName($this->thumbnail->getClientOriginalName())
                    ->toMediaCollection('speaker');
            }

            sleep(1);

            Toaster::success('Speaker added successfully!');
            \Log::info('Speaker added successfully with id: ' . $speaker->id);

            $this->resetForm();
            $this->dispatch('newAddedSpeaker')->to('admin.speaker.all-speaker');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            Toaster::error('Failed to add speaker: ' . $e->getMessage());
            \Log::error('Failed to add speaker: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->title = 'Mr';
        $this->name = '';
        $this->profession = '';
        $this->email = '';
        $this->about = '';
        $this->socials = [['platform' => '', 'url' => '']];
        $this->is_active = true;
        $this->thumbnail = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.speaker.add-speaker');
    }
}
