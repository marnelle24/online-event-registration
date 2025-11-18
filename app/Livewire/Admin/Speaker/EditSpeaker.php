<?php

namespace App\Livewire\Admin\Speaker;

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
    public $show = false;
    public $loading = false;

    protected $listeners = [
        'callEditSpeakerModal' => 'openModal',
    ];

    public function getSpeakerData($speakerId)
    {
        $this->speaker = Speaker::find($speakerId);
        
        if (!$this->speaker) {
            throw new \Exception('Speaker not found');
        }

        // Populate form fields with existing data
        $this->title = $this->speaker->title;
        $this->name = $this->speaker->name;
        $this->profession = $this->speaker->profession;
        $this->email = $this->speaker->email;
        $this->about = $this->speaker->about;
        $this->is_active = $this->speaker->is_active;
        
        // Handle socials array
        $speakerSocials = $this->speaker->processedSocials();

        if (is_array($speakerSocials) && !empty($speakerSocials)) {
            $this->socials = $speakerSocials;
        } else {
            $this->socials = [['platform' => '', 'url' => '']];
        }
    }

    public function openModal($id)
    {
        $this->loading = true;
        $this->show = true;
        
        try {
            $this->getSpeakerData($id);
            $this->loading = false;
        } catch (\Exception $e) {
            $this->loading = false;
            $this->show = false;
            Toaster::error('Error loading speaker data: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->show = false;
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
            if ($this->thumbnail) 
            {
                \Log::info('Uploading thumbnail...');
                // Clear existing media first
                $this->speaker->clearMediaCollection('speaker');
                \Log::info('Thumbnail cleared successfully!');
                // Add new media
                $this->speaker->addMedia($this->thumbnail->getRealPath())
                    ->usingFileName($this->thumbnail->getClientOriginalName())
                    ->toMediaCollection('speaker');
                \Log::info('Thumbnail uploaded successfully!');
            } 
            else 
            {
                \Log::info('No thumbnail uploaded!');
            }

            sleep(1);

            if ($updated) 
            {
                Toaster::success('Speaker updated successfully!');
                $this->show = false;
                $this->dispatch('updatedSpeaker')->to('admin.speaker.all-speaker');
                \Log::info('Speaker updated successfully!');
            } 
            else 
            {
                Toaster::error('Error updating speaker!');
                \Log::error('Error updating speaker!');
            }
            
        } catch (\Exception $e) {
            \Log::error('Error updating speaker: ' . $e->getMessage());
            Toaster::error('Error updating speaker: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.speaker.edit-speaker');
    }
}
