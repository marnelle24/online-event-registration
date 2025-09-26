<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditSpeaker extends Component
{
    use WithFileUploads;

    public $speaker;
    public $title;
    public $name;
    public $profession;
    public $email;
    public $about;
    public $socials = [];
    public $is_active;
    public $thumbnail;

    public function mount($speaker)
    {
        $this->speaker = $speaker;

        // Populate form fields with existing data
        $this->title = $speaker->title;
        $this->name = $speaker->name;
        $this->profession = $speaker->profession;
        $this->email = $speaker->email;
        $this->about = $speaker->about;
        $this->is_active = $speaker->is_active;
        
        // Handle socials array
        $speakerSocials = $speaker->processedSocials();

        if (is_array($speakerSocials) && !empty($speakerSocials)) {
            $this->socials = $speakerSocials;
        } else {
            $this->socials = [['platform' => '', 'url' => '']];
        }
    }

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

            $updated = $this->speaker->update([
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
                // Clear existing media first
                $this->speaker->clearMediaCollection('speaker');
                // Add new media
                $this->speaker->addMedia($this->thumbnail->getRealPath())
                    ->usingFileName($this->thumbnail->getClientOriginalName())
                    ->toMediaCollection('speaker');
            }

            sleep(1);

            if ($updated) {
                Toaster::success('Speaker updated successfully!');
                $this->dispatch('close-modal');
                $this->dispatch('updatedSpeaker');
            } else {
                Toaster::error('Error updating speaker!');
            }
        } catch (\Exception $e) {
            \Log::error('Error updating speaker: ' . $e->getMessage());
            Toaster::error('Error updating speaker: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.speaker.edit-speaker');
    }
}
