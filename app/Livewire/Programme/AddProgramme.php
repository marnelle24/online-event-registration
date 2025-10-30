<?php

namespace App\Livewire\Programme;

use App\Models\Programme;
use App\Models\Ministry;
use App\Services\CountryService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class AddProgramme extends Component
{
    use WithFileUploads;

    public $currency = '$';
    public $ministry_id;
    public $type = 'Event';
    public $hybridPlatformDetails = '';
    public $programmeCode;
    public $title;
    public $startDate;
    public $endDate;
    public $startTime;
    public $endTime;
    public $address;
    public $city;
    public $state;
    public $postalCode;
    public $country = '';
    public $price = 0;
    public $adminFee = 0;
    public $chequeCode = '';
    public $excerpt;
    public $customDate;
    public $description;
    public $contactPerson;
    public $contactNumber;
    public $contactEmail;
    public $limit = 0;
    public $status = 'pending';
    public $searchable = true;
    public $publishable = true;
    public $private_only = false;
    public $allowPreRegistration = true;
    public $allowWalkInRegistration = true;
    public $allowGroupRegistration = true;
    public $groupRegistrationMin = 2;
    public $groupRegistrationMax = 10;
    public $groupRegIndividualFee = 0;
    public $allowBreakoutSession = false;
    public $thumbnail;
    public $isHybridMode = false;

    public function isOnline()
    {
        return $this->isOnline;
    }
    public function isHybridMode()
    {
        return $this->isHybridMode;
    }

    public function countries()
    {
        $countryService = new CountryService();
        return $countryService->getCountriesWithFlagsCodesAndPhone();
    }

    public function resetForm()
    {
        $this->ministry_id = '';
        $this->type = 'Event';
        $this->programmeCode = '';
        $this->title = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->startTime = '';
        $this->endTime = '';
        $this->address = '';
        $this->city = '';
        $this->state = '';
        $this->postalCode = '';
        $this->country = 'Singapore';
        $this->price = 0;
        $this->adminFee = 0;
        $this->chequeCode = '';
        $this->excerpt = '';
        $this->description = '';
        $this->contactPerson = '';
        $this->contactNumber = '';
        $this->contactEmail = '';
        $this->customDate = '';
        $this->limit = 0;
        $this->status = 'pending';
        $this->searchable = true;
        $this->publishable = true;
        $this->private_only = false;
        $this->allowPreRegistration = true;
        $this->allowWalkInRegistration = true;
        $this->allowBreakoutSession = false;
        $this->allowGroupRegistration = false;
        $this->groupRegistrationMin = 2;
        $this->groupRegistrationMax = 10;
        $this->groupRegIndividualFee = 0;
        $this->isHybridMode = false;
        $this->hybridPlatformDetails = '';
        $this->thumbnail = null;
    }

    public function save()
    {
        $validatedData = $this->validate([
            'ministry_id' => 'required|exists:ministries,id',
            'type' => 'required|string',
            'programmeCode' => 'required|unique:programmes,programmeCode',
            'title' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'startTime' => 'nullable|date_format:H:i',
            'endTime' => 'nullable|date_format:H:i|after:startTime',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postalCode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'adminFee' => 'nullable|numeric|min:0',
            'chequeCode' => 'nullable|string|max:20',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'customDate' => 'nullable|string',
            'contactPerson' => 'nullable|string|max:255',
            'contactNumber' => 'nullable|string|max:20',
            'contactEmail' => 'nullable|email|max:255',
            'limit' => 'nullable|integer|min:0',
            'status' => 'nullable|string|in:pending,published,draft',
            'searchable' => 'boolean',
            'publishable' => 'boolean',
            'private_only' => 'boolean',
            'allowPreRegistration' => 'boolean',
            'allowWalkInRegistration' => 'boolean',
            'allowGroupRegistration' => 'boolean',
            'groupRegistrationMin' => 'nullable|integer|min:2',
            'groupRegistrationMax' => 'nullable|integer|min:2',
            'groupRegIndividualFee' => 'nullable|numeric|min:0',
            'allowBreakoutSession' => 'boolean',
            'isHybridMode' => 'boolean',
            'hybridPlatformDetails' => 'nullable|string|max:1000',
            'thumbnail' => 'nullable|image|max:2024|mimes:png,jpg,jpeg',
        ], [
            'ministry_id.required' => 'Ministry is required.',
            'ministry_id.exists' => 'Selected ministry does not exist.',
            'programmeCode.required' => 'Programme code is required.',
            'programmeCode.unique' => 'Programme code already exists.',
            'title.required' => 'Programme title is required.',
            'startDate.required' => 'Start date is required.',
            'endDate.after_or_equal' => 'End date must be after or equal to start date.',
            'endTime.after' => 'End time must be after start time.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price must be at least 0.',
            'customDate.nullable' => 'Custom date is optional.',
            'contactEmail.email' => 'Please provide a valid email address.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'thumbnail.max' => 'The thumbnail may not be greater than 2MB.',
        ]);

        try {
            $programme = Programme::create([
                'ministry_id' => $validatedData['ministry_id'],
                'type' => $validatedData['type'],
                'programmeCode' => $validatedData['programmeCode'],
                'title' => $validatedData['title'],
                'startDate' => $validatedData['startDate'],
                'endDate' => $validatedData['endDate'],
                'startTime' => $validatedData['startTime'],
                'endTime' => $validatedData['endTime'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'postalCode' => $validatedData['postalCode'],
                'country' => $validatedData['country'],
                'price' => $validatedData['price'],
                'adminFee' => $validatedData['adminFee'] ?? 0,
                'chequeCode' => $validatedData['chequeCode'] ?? '',
                'excerpt' => $validatedData['excerpt'],
                'description' => $validatedData['description'],
                'customDate' => $validatedData['customDate'],
                'contactPerson' => $validatedData['contactPerson'],
                'contactNumber' => $validatedData['contactNumber'],
                'contactEmail' => $validatedData['contactEmail'],
                'limit' => $validatedData['limit'] ?? 0,
                'status' => $validatedData['status'],
                'searchable' => $validatedData['searchable'] ?? true,
                'publishable' => $validatedData['publishable'] ?? true,
                'private_only' => $validatedData['private_only'] ?? false,
                'allowPreRegistration' => $validatedData['allowPreRegistration'] ?? true,
                'allowWalkInRegistration' => $validatedData['allowWalkInRegistration'] ?? true,
                'allowGroupRegistration' => $validatedData['allowGroupRegistration'] ?? false,
                'groupRegistrationMin' => $validatedData['groupRegistrationMin'] ?? 2,
                'groupRegistrationMax' => $validatedData['groupRegistrationMax'] ?? 10,
                'groupRegIndividualFee' => $validatedData['groupRegIndividualFee'] ?? 0,
                'allowBreakoutSession' => $validatedData['allowBreakoutSession'] ?? false,
            ]);

            // Handle thumbnail upload
            if ($this->thumbnail) {
                $programme->addMedia($this->thumbnail->getRealPath())
                    ->usingFileName($this->thumbnail->getClientOriginalName())
                    ->toMediaCollection('thumbnail');
            }

            sleep(1);

            if ($programme) {
                Toaster::success('Programme created successfully!');
                $this->resetForm();
                $this->dispatch('newAddedProgramme');
                return redirect()->route('admin.programmes.show', $programme->programmeCode);

            } 
            else {
                Toaster::error('Error creating programme!');
            }
        } catch (\Exception $e) {
            \Log::error('Error creating programme: ' . $e->getMessage());
            Toaster::error('Error creating programme: ' . $e->getMessage());
        }
    }

    public function render()
    {
        if (auth()->user()->role == 'admin') {
            $ministries = Ministry::orderBy('name')->get();
        } else {
            $ministries = Ministry::where('user_id', auth()->user()->id)->orderBy('name')->get();
        }

        $types = [
            'Event' => 'Event',
            'Conference' => 'Conference',
            'Workshop' => 'Workshop',
            'Seminar' => 'Seminar',
            'Retreat' => 'Retreat'
        ];
        $countries = $this->countries();
        
        return view('livewire.programme.add-programme', [
            'ministries' => $ministries,
            'types' => $types,
            'countries' => $countries
        ]);
    }
}
