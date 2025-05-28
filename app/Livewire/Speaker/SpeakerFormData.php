<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class SpeakerFormData extends Component
{
    use WithFileUploads;
    
    public $form = [
        'title' => 'Mr',
        'name' => 'marnelle apat',
        'profession' => 'IT professional',
        'email' => 'marnelle24@gmail.com',
        'about' => 'this is marnelle apat',
        'socials' => [
            ['platform' => '', 'url' => ''],
        ],
        'is_active' => true,
    ];

    public $thumbnail;

    public function addSocMedAccount()
    {
        $this->form['socials'][] = ['platform' => '', 'url' => ''];
    }

    public function removeSocMedAccount($index)
    {
        unset($this->form['socials'][$index]);
        $this->form['socials'] = array_values($this->form['socials']);
    }

    public function save()
    {
        $validatedData = $this->validate([
            'form.title' => 'sometimes|required|string|max:255',
            'form.name' => 'required|string|max:255',
            'form.profession' => 'sometimes|required|string|max:255',
            'form.email' => 'sometimes|required|email|max:255',
            'form.about' => 'sometimes|string',
            'form.socials.*.platform' => 'nullable|string|max:255',
            'form.socials.*.url' => 'nullable|max:255',
            'thumbnail' => 'nullable|image|max:2024|mimes:png,jpg,jpeg',
            
        ], [
            'form.title.required' => 'Title is required.',
            'form.name.required' => 'Name is required.',
            'form.profession.required' => 'Professional is required.',
            'form.email.required' => 'Email is required.',
            'form.about.required' => 'About section is required.',
            'form.socials.*.url.url' => 'Please provide a valid URL for the social media account.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'thumbnail.max' => 'The thumbnail may not be greater than 2MB.',
        ]);

        // remove empty social media accounts
        foreach ($validatedData['form']['socials'] as $key => $social) 
        {
            if (empty($social['platform']) || empty($social['url'])) 
            {
                unset($validatedData['form']['socials'][$key]);
            }
        }

        // reindex the array to remove gaps
        $validatedData['form']['socials'] = array_values($validatedData['form']['socials']);
        
        // Convert socials to JSON
        $socials = json_encode($validatedData['form']['socials']);
        
        $speaker = Speaker::create([
            'title' => $validatedData['form']['title'],
            'name' => $validatedData['form']['name'],
            'profession' => $validatedData['form']['profession'],
            'email' => $validatedData['form']['email'],
            'about' => $validatedData['form']['about'],
            'socials' => $socials,
        ]);
        
        // Handle thumbnail upload
        if ($this->thumbnail) 
        {
            $speaker->addMedia($this->thumbnail->getRealPath())
                ->usingFileName($this->thumbnail->getClientOriginalName())
                ->toMediaCollection('speaker');
        }
        $this->reset(['form', 'thumbnail']);
        $this->dispatch('newSpeakerCreated', $speaker->id);
    }

    public function resetForm()
    {
        $this->reset(['form', 'thumbnail']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.speaker.speaker-form-data');
    }
}
