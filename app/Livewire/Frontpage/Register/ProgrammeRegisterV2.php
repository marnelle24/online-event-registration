<?php

namespace App\Livewire\Frontpage\Register;

use Livewire\Component;
use App\Models\Programme;
use App\Models\Promocode;
use App\Models\Promotion;
use App\Models\Registrant;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Services\CountryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProgrammeRegisterV2 extends Component
{
    public Programme $programme;

    public bool $hasActivePromocodes = false;

    public ?int $selectedPromotionId = null;

    public ?Promotion $selectedPromotion = null;

    public int $currentStep = 1;

    public bool $isAuthenticated = false;

    public array $stepOrder = [];

    public int $totalSteps = 5;

    public bool $isGroupRegistration = false;

    public bool $allowGroupRegistration = false;

    public array $groupMembers = [];

    public array $formData = [];

    public ?Promocode $appliedPromocode = null;

    public ?float $finalPrice = null;

    public ?float $discountAmount = null;

    public ?float $effectivePrice = null;

    public ?string $promoMessage = null;

    public bool $promoError = false;

    public ?string $errorMessage = null;

    public array $validationErrors = [];

    public ?int $programmeId = null;

    public ?string $programmeCode = null;

    public ?string $country = null;

    public function mount(int $programmeId, string $programmeCode, bool $hasActivePromocodes = false, ?int $selectedPromotionId = null): void
    {

        $this->programmeId = $programmeId;
        $this->programmeCode = $programmeCode;
        $this->programme = Programme::with(['promotions', 'ministry', 'categories'])->findOrFail($programmeId);

        $this->hasActivePromocodes = $hasActivePromocodes;
        $this->selectedPromotionId = $selectedPromotionId;
        $this->allowGroupRegistration = (bool) $this->programme->allowGroupRegistration;

        $this->selectedPromotion = $this->resolvePromotionById($selectedPromotionId);
        
        $this->effectivePrice = $this->selectedPromotion?->price ?? $this->programme->price;
        $this->discountAmount = $this->selectedPromotion ? ($this->selectedPromotion->price ?? 0) : 0;
        $this->finalPrice = $this->effectivePrice + $this->programme->adminFee;
        
        $user = Auth::user();
        $this->isAuthenticated = (bool) $user;
        
        $this->formData = [
            'programmeCode' => $this->programme->programmeCode,
            'programmeId' => $this->programme->id,
            'promotionId' => $this->selectedPromotionId,
            'promocode' => '',
            'promocodeId' => null,
            'registrationType' => $user ? 'user' : 'guest',
            'title' => $user ? $user->title : 'Mr',
            'firstName' => $user->firstname ?? 'Marnelle',
            'lastName' => $user->lastname ?? 'Apat',
            'nric' => '1234',
            'email' => $user->email ?? 'marnelle.apat@biblesociety.sg',
            'country' => '+65',
            'contactNumber' => '9177724780',
            'address' => 'Arcenas Street',
            'city' => 'Singapore',
            'postalCode' => '059100',
        ];

        $this->stepOrder = $this->buildStepOrder();
        $this->totalSteps = count($this->stepOrder);
        $this->currentStep = 1;
    }

    public function render()
    {
        $countryService = new CountryService();
        $countries = $countryService->getCountryPhoneCodeAndFlag();
        return view('livewire.frontpage.register.programme-register-v2', [
            'countries' => $countries
        ]);
    }

    public function getHasActivePromotionProperty(): bool
    {
        return (bool) $this->selectedPromotion;
    }

    public function getDefaultPriceLabelProperty(): string
    {
        return $this->programme->price > 0
            ? '$' . number_format($this->programme->price, 2)
            : 'Free';
    }

    public function getPromotionPriceLabelProperty(): ?string
    {
        if (!$this->selectedPromotion) {
            return null;
        }

        return $this->selectedPromotion->price > 0
            ? '$' . number_format($this->selectedPromotion->price, 2)
            : 'Free';
    }

    public function getGroupMinSizeProperty(): int
    {
        // If promotion is selected and it's a group promotion, use promotion limits
        if ($this->selectedPromotion && $this->selectedPromotion->isGroup) {
            return $this->selectedPromotion->minGroup ?? 2;
        }
        
        // Otherwise use programme defaults
        return $this->programme->groupRegistrationMin ?? 2;
    }

    public function getGroupMaxSizeProperty(): int
    {
        // If promotion is selected and it's a group promotion, use promotion limits
        if ($this->selectedPromotion && $this->selectedPromotion->isGroup) {
            return $this->selectedPromotion->maxGroup ?? 10;
        }
        
        // Otherwise use programme defaults
        return $this->programme->groupRegistrationMax ?? 10;
    }

    public function selectRegistrationType(string $type): void
    {
        $this->formData['registrationType'] = $type;
    }

    public function toggleGroupRegistration(bool $value): void
    {
        if (!$this->groupStepIsAvailable()) {
            $this->isGroupRegistration = false;
            $this->groupMembers = [];
            return;
        }

        $this->isGroupRegistration = $value;

        if (!$value) {
            $this->groupMembers = [];
        }
    }

    public function addGroupMember(): void
    {
        $max = $this->groupMaxSize;

        if (!$this->groupStepIsAvailable()) {
            return;
        }

        // Check if we've reached the maximum (including the main registrant)
        if (count($this->groupMembers) >= ($max - 1)) {
            return;
        }

        $memberNumber = count($this->groupMembers) + 2; // +2 because member 1 is the main registrant

        $this->groupMembers[] = [
            'title' => 'Mr',
            'firstName' => 'member2-marnelle',
            'lastName' => 'member2-Apat',
            'nric' => '1234',
            'email' => 'marnelle.apat@biblesociety.sg',
            'contactNumber' => '9177724780',
            'country' => '+65',
            'address' => 'Arcenas Street-member',
            'city' => 'Singapore',
            'postalCode' => '059100-member',
            'showDetails' => true,
        ];
    }

    public function hydrate(): void
    {
        foreach ($this->groupMembers as $key => $member) {
            if (!array_key_exists('showDetails', $member)) {
                $this->groupMembers[$key]['showDetails'] = true;
            }
        }
    }

    public function removeGroupMember(int $index): void
    {
        if (isset($this->groupMembers[$index])) {
            unset($this->groupMembers[$index]);
            $this->groupMembers = array_values($this->groupMembers);
        }
    }

    public function nextStep(): void
    {
        if ($this->currentStep >= $this->totalSteps) {
            return;
        }

        if (!$this->validateStep($this->currentStepName())) {
            return;
        }

        $this->currentStep++;
    }

    public function previousStep(): void
    {
        if ($this->currentStep <= 1) {
            return;
        }

        $this->currentStep--;
    }

    public function applyPromocode(): void
    {
        $this->resetPromocodeState();

        if (!$this->hasActivePromocodes || empty($this->formData['promocode'])) {
            $this->promoError = true;
            $this->promoMessage = 'Please enter a promo code.';
            $this->recalculateTotals();
            return;
        }

        $promocode = Promocode::where('promocode', strtoupper($this->formData['promocode']))
            ->where('programCode', $this->programme->programmeCode)
            ->where('isActive', true)
            ->first();

        if (!$promocode) {
            $this->promoError = true;
            $this->promoMessage = 'Invalid promo code.';
            $this->recalculateTotals();
            return;
        }

        $now = now();

        if ($promocode->startDate && $now->lt($promocode->startDate)) {
            $this->promoError = true;
            $this->promoMessage = 'Promo code is not yet active.';
            $this->recalculateTotals();
            return;
        }

        if ($promocode->endDate && $now->gt($promocode->endDate)) {
            $this->promoError = true;
            $this->promoMessage = 'Promo code has expired.';
            $this->recalculateTotals();
            return;
        }

        if ($promocode->maxUses && $promocode->usedCount >= $promocode->maxUses) {
            $this->promoError = true;
            $this->promoMessage = 'Promo code has reached maximum usage.';
            $this->recalculateTotals();
            return;
        }

        $this->appliedPromocode = $promocode;
        $this->formData['promocodeId'] = $promocode->id;
        $this->finalPrice = (float) $promocode->price + (float) $this->programme->adminFee;
        $this->discountAmount = max(0, ($this->effectivePrice ?? $this->programme->price) - $this->finalPrice);
        $this->promoMessage = 'Promo code applied successfully.';
        $this->recalculateTotals();
    }

    public function submit()
    {
        if (!$this->validateStep($this->currentStepName(), true)) {
            return;
        }

        $data = $this->validate($this->rules(), $this->messages(), $this->validationAttributes());

        try {
            $promotion = $this->resolvePromotionById(Arr::get($data, 'formData.promotionId'));

            $promotionId = $promotion?->id;
            $promotionPrice = $promotion?->price;

            $promocode = null;
            if ($data['formData']['promocodeId']) 
            {
                $promocode = Promocode::find($data['formData']['promocodeId']);
            }

            $netAmount = $this->finalPrice;
            $discountAmount = $promotionPrice ?? 0;

            $confirmationCode = $this->programme->programmeCode . '_' . strtoupper(substr(uniqid(), -6));
            $groupRegistrationId = $data['isGroupRegistration'] ? $confirmationCode : null;

            $mainRegistrant = Registrant::create([
                'regCode' => $netAmount > 0 ? null : $this->generateRegCode($this->programme->programmeCode),
                'confirmationCode' => $confirmationCode,
                'programCode' => $this->programme->programmeCode,
                'programme_id' => $this->programme->id,
                'nric' => $data['formData']['nric'],
                'title' => $data['formData']['title'],
                'firstName' => $data['formData']['firstName'],
                'lastName' => $data['formData']['lastName'],
                'address' => $data['formData']['address'],
                'city' => $data['formData']['city'],
                'postalCode' => $data['formData']['postalCode'],
                'email' => $data['formData']['email'],
                'contactNumber' => collect([
                    Arr::get($data, 'formData.country'),
                    Arr::get($data, 'formData.contactNumber'),
                ])->filter(fn ($value) => filled($value))->implode(' '),
                'price' => $this->programme->price,
                'discountAmount' => $discountAmount,
                'netAmount' => $netAmount,
                'promocode_id' => $promocode?->id,
                'promotion_id' => $promotionId,
                'paymentStatus' => $netAmount > 0 ? 'pending' : 'free',
                'regStatus' => $netAmount > 0 ? 'pending' : 'confirmed',
                'registrationType' => $data['formData']['registrationType'],
                'groupRegistrationID' => $groupRegistrationId,
            ]);

            if ($data['isGroupRegistration'] && !empty($data['groupMembers'])) {
                foreach ($data['groupMembers'] as $member) {
                    Registrant::create([
                        'confirmationCode' => $confirmationCode,
                        'programCode' => $this->programme->programmeCode,
                        'programme_id' => $this->programme->id,
                        'nric' => $member['nric'] ?? null,
                        'title' => $member['title'],
                        'firstName' => $member['firstName'],
                        'lastName' => $member['lastName'],
                        'email' => $member['email'],
                        'contactNumber' => collect([
                            $member['country'] ?? null,
                            $member['contactNumber'] ?? null,
                        ])->filter(fn ($value) => filled($value))->implode(' '),
                        'address' => $member['address'] ?? null,
                        'city' => $member['city'] ?? null,
                        'postalCode' => $member['postalCode'] ?? null,
                        'price' => 0,
                        'discountAmount' => 0,
                        'netAmount' => 0,
                        'promocode_id' => $promocode?->id,
                        'promotion_id' => $promotionId,
                        'paymentStatus' => $netAmount > 0 ? 'group_member_pending' : 'free',
                        'regStatus' => $netAmount > 0 ? 'group_reg_pending' : 'confirmed',
                        'registrationType' => 'guest_group_member',
                        'groupRegistrationID' => $groupRegistrationId,
                    ]);
                }
            }

            $redirectUrl = route('registration.confirmation', ['confirmationCode' => $confirmationCode]);

            if ($netAmount > 0 && !$this->programme->allowPreRegistration) {
                $redirectUrl = route('registration.payment.v2', ['confirmationCode' => $confirmationCode]);
            }

            return redirect()->to($redirectUrl);
        } catch (\Throwable $throwable) {
            report($throwable);
            $this->errorMessage = 'An unexpected error occurred while processing your registration. Please try again.';
        }
    }

    protected function rules(): array
    {
        $groupRules = [
            'groupMembers' => ['sometimes', 'array'],
            'groupMembers.*.title' => ['nullable', 'string'],
            'groupMembers.*.firstName' => ['required', 'string'],
            'groupMembers.*.lastName' => ['required', 'string'],
            'groupMembers.*.email' => ['required', 'email'],
            'groupMembers.*.contactNumber' => $this->contactNumberRules(true),
            'groupMembers.*.country' => $this->countryRules(true),
            'groupMembers.*.nric' => ['nullable', 'string'],
            'groupMembers.*.address' => ['nullable', 'string'],
            'groupMembers.*.city' => ['nullable', 'string'],
            'groupMembers.*.postalCode' => ['nullable', 'string'],
        ];

        return [
            'formData.title' => ['nullable', 'string'],
            'formData.firstName' => ['required', 'string'],
            'formData.lastName' => ['required', 'string'],
            'formData.email' => ['required', 'email'],
            'formData.contactNumber' => $this->contactNumberRules(),
            'formData.country' => $this->countryRules(),
            'formData.nric' => ['nullable', 'string'],
            'formData.address' => ['nullable', 'string'],
            'formData.city' => ['nullable', 'string'],
            'formData.postalCode' => ['nullable', 'string'],
            'formData.registrationType' => ['required', Rule::in(['user', 'guest'])],
            'formData.promotionId' => ['nullable', 'exists:promotions,id'],
            'formData.promocodeId' => ['nullable', 'exists:promocodes,id'],
            'isGroupRegistration' => ['boolean'],
        ] + ($this->isGroupRegistration ? $groupRules : []);
    }

    protected function validationAttributes(): array
    {
        return [
            'formData.title' => 'title',
            'formData.firstName' => 'first name',
            'formData.lastName' => 'last name',
            'formData.email' => 'email address',
            'formData.contactNumber' => 'contact number',
            'formData.country' => 'country',
            'groupMembers.*.firstName' => 'group member first name',
            'groupMembers.*.lastName' => 'group member last name',
            'groupMembers.*.email' => 'group member email',
            'groupMembers.*.contactNumber' => 'group member contact number',
            'groupMembers.*.country' => 'group member country',
            'groupMembers.*.address' => 'group member address',
            'groupMembers.*.city' => 'group member city',
            'groupMembers.*.postalCode' => 'group member postal code',
        ];
    }

    public function messages(): array
    {
        return [
            'formData.firstName.required' => 'First name is required',
            'formData.lastName.required' => 'Last name is required',
            'formData.email.required' => 'Email is required',
            'formData.email.email' => 'Invalid email address',
            'formData.contactNumber.required' => 'Contact number is required',
            'formData.contactNumber.string' => 'Contact number must be a string',
            'formData.country.required' => 'Country is required',
            'groupMembers.*.firstName.required' => 'Group member first name is required',
            'groupMembers.*.lastName.required' => 'Group member last name is required',
            'groupMembers.*.email.required' => 'Group member email is required',
            'groupMembers.*.email.email' => 'Invalid group member email address',
            'groupMembers.*.contactNumber.required' => 'Group member contact number is required',
            'groupMembers.*.contactNumber.string' => 'Group member contact number must be a string',
            'groupMembers.*.nric.required' => 'Group member NRIC is required',
            'groupMembers.*.nric.string' => 'Group member NRIC must be a string',
            'groupMembers.*.nric.max' => 'Group member NRIC must be less than 10 characters',
            'groupMembers.*.nric.min' => 'Group member NRIC must be at least 10 characters',
            'groupMembers.*.nric.regex' => 'Group member NRIC must be in the format of 1234',
            'groupMembers.*.country.required' => 'Group member country is required',
            'groupMembers.*.address.required' => 'Group member address is required',
            'groupMembers.*.city.required' => 'Group member city is required',
            'groupMembers.*.postalCode.required' => 'Group member postal code is required',
        ];
    }

    protected function validateStep(string $stepName, bool $final = false): bool
    {
        $this->validationErrors = [];
        $this->errorMessage = null;

        try {
            switch ($stepName) {
                case 'account':
                    if (!$final && !$this->formData['registrationType']) {
                        throw ValidationException::withMessages([
                            'formData.registrationType' => 'Please select a registration type.',
                        ]);
                    }
                    break;
                case 'details':
                    Validator::make($this->formData, [
                        'title' => ['nullable', 'string'],
                        'firstName' => ['required', 'string'],
                        'lastName' => ['required', 'string'],
                        'email' => ['required', 'email'],
                        'contactNumber' => $this->contactNumberRules(),
                        'country' => $this->countryRules(),
                    ], [
                        'firstName.required' => $this->messages()['formData.firstName.required'],
                        'lastName.required' => $this->messages()['formData.lastName.required'],
                        'email.required' => $this->messages()['formData.email.required'],
                        'email.email' => $this->messages()['formData.email.email'],
                        'contactNumber.required' => $this->messages()['formData.contactNumber.required'],
                        'contactNumber.string' => $this->messages()['formData.contactNumber.string'],
                        'country.required' => $this->messages()['formData.country.required'],
                    ], [
                        'firstName' => $this->validationAttributes()['formData.firstName'],
                        'lastName' => $this->validationAttributes()['formData.lastName'],
                        'email' => $this->validationAttributes()['formData.email'],
                        'contactNumber' => $this->validationAttributes()['formData.contactNumber'],
                        'country' => $this->validationAttributes()['formData.country'],
                    ])->validate();
                    break;
                case 'group':
                    if ($this->isGroupRegistration) {
                        $min = $this->groupMinSize;
                        $max = $this->groupMaxSize;
                        $totalMembers = count($this->groupMembers) + 1;

                        if ($totalMembers < $min || $totalMembers > $max) {
                            throw ValidationException::withMessages([
                                'groupMembers' => "Group registration must have between {$min} and {$max} participants (including you).",
                            ]);
                        }

                        Validator::make(['groupMembers' => $this->groupMembers], [
                            'groupMembers' => ['required', 'array'],
                            'groupMembers.*.title' => ['nullable', 'string'],
                            'groupMembers.*.firstName' => ['required', 'string'],
                            'groupMembers.*.lastName' => ['required', 'string'],
                            'groupMembers.*.email' => ['required', 'email'],
                            'groupMembers.*.contactNumber' => $this->contactNumberRules(true),
                            'groupMembers.*.country' => $this->countryRules(true),
                            'groupMembers.*.address' => ['nullable', 'string'],
                            'groupMembers.*.city' => ['nullable', 'string'],
                            'groupMembers.*.postalCode' => ['nullable', 'string'],
                        ], [
                            'groupMembers.*.firstName.required' => $this->messages()['groupMembers.*.firstName.required'],
                            'groupMembers.*.lastName.required' => $this->messages()['groupMembers.*.lastName.required'],
                            'groupMembers.*.email.required' => $this->messages()['groupMembers.*.email.required'],
                            'groupMembers.*.email.email' => $this->messages()['groupMembers.*.email.email'],
                            'groupMembers.*.contactNumber.required' => $this->messages()['groupMembers.*.contactNumber.required'],
                            'groupMembers.*.contactNumber.string' => $this->messages()['groupMembers.*.contactNumber.string'],
                            'groupMembers.*.nric.required' => $this->messages()['groupMembers.*.nric.required'],
                            'groupMembers.*.nric.string' => $this->messages()['groupMembers.*.nric.string'],
                            'groupMembers.*.nric.max' => $this->messages()['groupMembers.*.nric.max'],
                            'groupMembers.*.nric.min' => $this->messages()['groupMembers.*.nric.min'],
                            'groupMembers.*.nric.regex' => $this->messages()['groupMembers.*.nric.regex'],
                            'groupMembers.*.country.required' => $this->messages()['groupMembers.*.country.required'],
                            'groupMembers.*.address.required' => $this->messages()['groupMembers.*.address.required'],
                            'groupMembers.*.city.required' => $this->messages()['groupMembers.*.city.required'],
                            'groupMembers.*.postalCode.required' => $this->messages()['groupMembers.*.postalCode.required'],
                        ], [
                            'groupMembers.*.firstName' => $this->validationAttributes()['groupMembers.*.firstName'],
                            'groupMembers.*.lastName' => $this->validationAttributes()['groupMembers.*.lastName'],
                            'groupMembers.*.email' => $this->validationAttributes()['groupMembers.*.email'],
                            'groupMembers.*.contactNumber' => $this->validationAttributes()['groupMembers.*.contactNumber'],
                            'groupMembers.*.country' => $this->validationAttributes()['groupMembers.*.country'],
                            'groupMembers.*.address' => $this->validationAttributes()['groupMembers.*.address'],
                            'groupMembers.*.city' => $this->validationAttributes()['groupMembers.*.city'],
                            'groupMembers.*.postalCode' => $this->validationAttributes()['groupMembers.*.postalCode'],
                        ])->validate();
                    }
                    break;
                case 'promo':
                    // Promo code step: nothing additional to validate
                    break;
            }

            return true;
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $this->validationErrors = $exception->errors();
            $this->errorMessage = 'Please review the highlighted fields.';
            return false;
        }
    }

    protected function contactNumberRules(bool $forGroup = false): array
    {
        $rules = ['string'];

        if ($this->contactNumberIsRequired($forGroup)) {
            array_unshift($rules, 'required');
        } else {
            array_unshift($rules, 'nullable');
        }

        return $rules;
    }

    protected function countryRules(bool $forGroup = false): array
    {
        $rules = ['string'];

        if ($this->contactNumberIsRequired($forGroup)) {
            array_unshift($rules, 'required');
        } else {
            array_unshift($rules, 'nullable');
        }

        return $rules;
    }

    protected function contactNumberIsRequired(bool $forGroup = false): bool
    {
        return true;
    }

    protected function resetPromocodeState(): void
    {
        $this->promoError = false;
        $this->promoMessage = null;
        $this->appliedPromocode = null;
        $this->formData['promocodeId'] = null;
    }

    protected function recalculateTotals(): void
    {
        $basePrice = $this->effectivePrice ?? $this->programme->price;

        $adminFee = floatval($this->programme->adminFee) <= 0 ? 0 : floatval($this->programme->adminFee);
        $basePrice += $adminFee;

        if ($this->appliedPromocode) 
        {
            $this->finalPrice = (float) $this->appliedPromocode->price + $adminFee;
            $this->discountAmount = max(0, $basePrice - $this->finalPrice);
            return;
        }

        $this->finalPrice = $basePrice + $adminFee;
        $this->discountAmount = $this->selectedPromotion
            ? max(0, ($this->programme->price - $basePrice))
            : 0;
    }

    protected function groupStepIsAvailable(): bool
    {
        if ($this->selectedPromotion && $this->selectedPromotion->isGroup && $this->allowGroupRegistration)
            return true;
        
        return false;
    }

    protected function buildStepOrder(): array
    {
        $steps = [];

        if (!$this->isAuthenticated) {
            $steps[] = 'account';
        }

        $steps[] = 'details';

        if ($this->groupStepIsAvailable()) {
            $steps[] = 'group';
        }

        if ($this->hasActivePromocodes) {
            $steps[] = 'promo';
        }

        $steps[] = 'confirm';
        
        if (!$this->programme->allowPreRegistration) {
            $steps[] = 'payment';
        }

        return $steps;
    }

    protected function currentStepName(): string
    {
        return $this->stepOrder[$this->currentStep - 1] ?? 'confirm';
    }

    protected function resolvePromotionById(?int $promotionId): ?Promotion
    {
        if (!$promotionId) {
            return null;
        }

        $promotion = $this->programme->promotions->firstWhere('id', $promotionId);

        if (!$promotion) {
            return null;
        }

        return $this->promotionIsCurrentlyActive($promotion) ? $promotion : null;
    }

    protected function promotionIsCurrentlyActive(Promotion $promotion): bool
    {
        $now = now();

        if (!$promotion->isActive) {
            return false;
        }

        if ($promotion->startDate && $promotion->startDate->gt($now)) {
            return false;
        }

        if ($promotion->endDate && $promotion->endDate->lt($now)) {
            return false;
        }

        return true;
    }

    protected function generateRegCode(string $programmeCode): string
    {
        $count = Registrant::where('programCode', $programmeCode)->count();
        $registrantNumber = $count + 1;
        $regCode = $programmeCode . '_' . str_pad($registrantNumber, 3, '0', STR_PAD_LEFT);

        while (Registrant::where('regCode', $regCode)->exists()) {
            $registrantNumber++;
            $regCode = $programmeCode . '_' . str_pad($registrantNumber, 3, '0', STR_PAD_LEFT);
        }

        return $regCode;
    }
}