@php
    $currentStepName = $this->currentStepName();
    $defaultPriceLabel = $this->defaultPriceLabel;
    $promotionPriceLabel = $this->promotionPriceLabel;
    $hasActivePromotion = $this->hasActivePromotion;
@endphp

<div class="space-y-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($programme->getFirstMediaUrl('thumbnail'))
            <div class="md:h-80 h-48 rounded-t-lg bg-cover bg-no-repeat bg-center border-b border-slate-400/70 bg-teal-900"
                 style="background-image: url('{{ $programme->getFirstMediaUrl('thumbnail') }}')"></div>
        @endif

        <div class="flex flex-col justify-between gap-6 md:flex-row overflow-hidden p-6 md:p-8">
            <div class="flex-1">
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">{{ $programme->title }}</h1>
                <p class="text-base text-teal-700/80 font-thin mb-4">{{ 'By '.$programme->ministry->name }}</p>

                <div class="flex flex-col gap-3 text-sm md:text-base text-slate-600">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $programme->programmeDates }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0Z" />
                        </svg>
                        <span>{{ $programme->programmeTimes }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 stroke-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @if($programme->price > 0)
                            @if($hasActivePromotion)
                                <span class="text-base font-bold">{{ $defaultPriceLabel }}</span>
                            @else
                                <span class="text-base font-bold text-slate-800">{{ $defaultPriceLabel }}</span>
                            @endif
                        @else
                            <span class="text-base font-bold uppercase text-slate-600">
                                Free
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap mt-6">
                    @if($programme->categories->isNotEmpty())
                        @foreach($programme->categories as $category)
                            <span class="bg-teal-100/70 capitalize text-teal-800 px-3 border border-teal-800/70 py-1 rounded-full text-sm font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="md:w-80 bg-teal-50 rounded-lg p-6 border border-teal-100">
                <h3 class="text-sm uppercase font-semibold tracking-wide text-teal-700 mb-4">Registration Summary</h3>
                <dl class="space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between">
                        <dt>Standard Fee</dt>
                        <dd class="font-semibold text-slate-900 text-right {{ ($selectedPromotion || $appliedPromocode) ? 'line-through text-slate-400' : '' }}">{{ $defaultPriceLabel }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Admin Fee</dt>
                        <dd class="font-semibold text-slate-900 text-right">{{ floatval($programme->adminFee) >= 0 ? '$'.number_format(floatval($programme->adminFee), 2) : 'Free' }}</dd>
                    </div>
                    @if($selectedPromotion)
                        <div class="flex justify-between">
                            <dt>Promotion</dt>
                            <dd class="font-semibold text-slate-900 text-right">
                                {{ $selectedPromotion ? $selectedPromotion->title : 'Standard' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Promotion Price</dt>
                            <dd class="font-semibold text-teal-700 text-right">
                                {{ $promotionPriceLabel ?? 'N/A' }}
                            </dd>
                        </div>
                    @endif
                    @if($appliedPromocode)
                        <div class="flex justify-between">
                            <dt>Promocode Applied</dt>
                            <dd class="font-semibold text-teal-700 text-right">
                                {{ $appliedPromocode->promocode }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Promocode Price</dt>
                            <dd class="font-semibold text-teal-700 text-right">
                                {{ '$'.number_format(floatval($appliedPromocode->price), 2) }}
                            </dd>
                        </div>
                    @endif
                    <div class="flex justify-between border-t border-slate-200 pt-3">
                        <dt>Total Due Now</dt>
                        <dd class="text-lg font-bold text-slate-900 text-right">
                            {{ $finalPrice !== null ? ($finalPrice <= 0 ? 'Free' : '$'.number_format(floatval($finalPrice), 2)) : $defaultPriceLabel }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="border-b border-slate-200 px-6 md:px-8 py-5 bg-teal-600 text-white">
            <h2 class="text-2xl font-bold text-white">Registration Process</h2>
            <p class="text-sm text-white">Complete each step to secure your spot.</p>
        </div>

        <div class="space-y-10 mx-auto">
            <div class="pt-6 md:pt-0 md:p-4 md:space-y-4 space-y-0">
                @php
                    $stepLabels = [
                        'account' => 'Account',
                        'details' => 'Details',
                        'group' => 'Group',
                        'promo' => 'Promo',
                        'confirm' => 'Confirm',
                        'payment' => 'Payment',
                    ];
                @endphp
                <ol class="mt-10 md:flex hidden flex-col md:flex-row md:items-center md:justify-between gap-3 md:gap-0 ml-40">
                    @foreach($stepOrder as $stepIndex => $stepKey)
                        <li class="flex items-center md:flex-1">
                            <div class="flex flex-col justify-center gap-2 items-center">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border-2
                                    {{ $currentStep >= ($stepIndex + 1) ? 'border-teal-600 bg-teal-600 text-white' : 'border-slate-300 bg-white text-slate-500' }}">
                                    <span class="text-sm font-semibold">{{ $loop->iteration }}</span>
                                </div>
                                <span class="text-sm font-medium {{ $currentStep >= ($stepIndex + 1) ? 'text-teal-700' : 'text-slate-500' }}">
                                    {{ $stepLabels[$stepKey] ?? ucfirst($stepKey) }}
                                </span>
                            </div>
                            @if(!$loop->last && $stepKey !== 'payment')
                                <div class="hidden md:block flex-1 h-px bg-gradient-to-r {{ $currentStep > ($stepIndex + 1) ? 'from-teal-400 to-teal-600' : 'from-slate-200 to-slate-200' }} ml-4 mr-4"></div>
                            @endif
                        </li>
                    @endforeach
                </ol>
                {{-- mobile view --}}
                <div class="md:hidden flex justify-center items-center gap-4">
                    @foreach($stepOrder as $stepIndex => $stepKey)
                        <div class="flex flex-col items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 {{ $currentStep >= ($stepIndex + 1) ? 'stroke-teal-700' : 'text-slate-500' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>
                            <p class="text-[10px] font-medium {{ $currentStep >= ($stepIndex + 1) ? 'text-teal-100 font-bold bg-teal-700 px-2 py-0.5 rounded-full' : 'text-slate-500' }}"">{{$stepLabels[$stepKey] ?? ucfirst($stepKey)}}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($errorMessage)
                <div class="px-6 md:px-8">
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-red-800">Heads up</h3>
                        <p class="text-sm text-red-700 mt-1">{{ $errorMessage }}</p>
                        @if(!empty($validationErrors))
                            <ul class="mt-3 space-y-1 text-sm text-red-700 list-disc list-inside">
                                @foreach($validationErrors as $field => $messages)
                                    <li>{{ is_array($messages) ? $messages[0] : $messages }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
            <form wire:submit.prevent="submit" class="py-6 px-6 md:px-8">
                @if(!$isAuthenticated && $currentStepName === 'account')
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Choose Registration Method</h3>
                            <p class="text-slate-600">Register as a guest or log in to your existing account.</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <button type="button"
                                    wire:click="selectRegistrationType('guest')"
                                    class="text-left border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1
                                        {{ $formData['registrationType'] === 'guest' ? 'border-teal-600 bg-teal-50' : 'border-slate-200 hover:border-teal-500' }}">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center
                                        {{ $formData['registrationType'] === 'guest' ? 'border-teal-600 bg-teal-600' : 'border-slate-300' }}">
                                        @if($formData['registrationType'] === 'guest')
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <h4 class="text-lg font-bold text-slate-800 mb-2">Register as Guest</h4>
                                <p class="text-sm text-slate-600">Quick registration without creating an account. Perfect for one-time registrations.</p>
                            </button>

                            <a href="{{ route('login', ['redirect' => url()->full()]) }}"
                               class="border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-slate-200 hover:border-teal-500 block">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-800 mb-2">Login to Account</h4>
                                <p class="text-sm text-slate-600">Already have an account? Log in to access your previous registrations and faster checkout.</p>
                            </a>
                        </div>

                        <div class="flex justify-end">
                            <button type="button"
                                    wire:click="nextStep"
                                    class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if($currentStepName === 'details')
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Registrant Details</h3>
                            <p class="text-slate-600">Please provide your details to complete the registration.</p>
                        </div>

                        @if($isAuthenticated)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-blue-800">Welcome back, {{ \Auth::user()->firstname ?? \Auth::user()->name }}!</p>
                                        <p class="text-sm text-blue-700 mt-1">We've pre-filled some information from your account. Please review and update as needed.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="col-span-3">
                                <div class="grid grid-cols-1 md:grid-cols-4 md:gap-x-5 gap-x-0 gap-y-5">
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Title</label>
                                        <select wire:model.defer="formData.title" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Rev">Rev</option>
                                        </select>
                                    </div>
                                    {{-- @dump(array_keys($validationErrors)) --}}
                                    <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            @php
                                                $errorClass = in_array('firstName', array_keys($validationErrors)) ||
                                                in_array('formData.lastName', array_keys($validationErrors)) ||
                                                in_array('formData.email', array_keys($validationErrors)) ||
                                                in_array('formData.contactNumber', array_keys($validationErrors)) ||
                                                in_array('formData.country', array_keys($validationErrors)) ||
                                                in_array('formData.address', array_keys($validationErrors)) ||
                                                in_array('formData.city', array_keys($validationErrors)) ||
                                                in_array('formData.postalCode', array_keys($validationErrors)) ||
                                                in_array('formData.nric', array_keys($validationErrors))
                                                ? 'border-red-600' : 'border-slate-300';
                                            @endphp
                                            <label class="block text-sm font-medium text-slate-700 mb-2">First Name <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model.defer="formData.firstName"
                                                class="{{$errorClass}} w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                placeholder="John"
                                            >
                                        </div>
            
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-2">Last Name <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model.defer="formData.lastName" 
                                                placeholder="Doe"
                                                class="{{$errorClass}} w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-3">
                                <div class="grid grid-cols-1 md:grid-cols-4 md:gap-x-5 gap-x-0 gap-y-5">
                                    <div class="col-span-1">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-1">NRIC <span class="text-slate-500 px-1">(Last 4-digit)</span></label>
                                            <input type="text" wire:model.defer="formData.nric" 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                placeholder="Last 4-digit (e.g. 1234)"
                                                maxlength="4"
                                            >
                                            @error('formData.nric') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-1">Email <span class="text-red-500">*</span></label>
                                            <input type="email" wire:model.defer="formData.email" 
                                                class="{{$errorClass}} w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                placeholder="name@email.com"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-1">Contact Number</label>
                                            <div class="flex items-center gap-1">
                                                <x-country-select 
                                                    wire:model.defer="formData.country"
                                                    class="{{$errorClass}} w-[100px] px-2 py-3 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    :required="false"
                                                    format="phonecode" 
                                                />

                                                <input type="text" wire:model.defer="formData.contactNumber" 
                                                    class="{{$errorClass}} w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    placeholder="eg. 123456789"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-3">
                                <div class="grid grid-cols-1 md:grid-cols-4 md:gap-x-5 gap-x-0 gap-y-5">
                                    <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-1">Address</label>
                                            <input type="text" wire:model.defer="formData.address" 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                placeholder="eg. 123 Main St"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-1">City</label>
                                            <input type="text" wire:model.defer="formData.city" 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                placeholder="eg. Kuala Lumpur"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-1">Postal Code</label>
                                            <input type="text" wire:model.defer="formData.postalCode" 
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                placeholder="eg. 12345"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex justify-between">
                            @if($currentStep > 1)
                                <button type="button" wire:click="previousStep" class="flex items-center justify-center gap-1 bg-slate-100 text-slate-700 px-6 py-3 border border-slate-200 rounded-lg font-semibold hover:bg-slate-200 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back
                                </button>
                            @else
                                <span></span>
                            @endif
                            <button type="button" wire:click="nextStep" class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 transition">
                                Continue
                            </button>
                        </div>
                    </div>
                @endif

                @if($allowGroupRegistration && $currentStepName === 'group')
                    <div class="space-y-6">
                        <div class="flex md:items-center items-start justify-between">
                            <div>
                                <h3 class="md:text-2xl text-lg font-bold text-slate-800 mb-2">Group Registration</h3>
                                <p class="text-slate-600 md:text-base text-sm leading-tight">Add team members to register together.</p>
                            </div>
                            <div class="flex flex-col md:flex-row gap-2 items-center space-x-2">
                                <span class="md:text-sm text-xs text-slate-600">Register as group?</span>
                                <div class="flex items-center space-x-3">
                                    <button type="button"
                                            wire:click="toggleGroupRegistration(true)"
                                            class="px-4 py-2 hover:bg-teal-600 hover:text-white transition-all duration-300 rounded-full text-sm font-semibold {{ $isGroupRegistration ? 'bg-teal-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                                        Yes
                                    </button>
                                    <button type="button"
                                            wire:click="toggleGroupRegistration(false)"
                                            class="px-4 py-2 hover:bg-teal-600 hover:text-white transition-all duration-300 rounded-full text-sm font-semibold {{ !$isGroupRegistration ? 'bg-teal-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-300 my-4 border-dashed" />

                        <div class="space-y-4 min-h-[200px]">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                                <div class="flex-1">
                                    <p class="text-sm text-slate-600">
                                        Minimum <span class="font-semibold text-teal-700">{{ $this->groupMinSize }}</span> participants, maximum 
                                        <span class="font-semibold text-teal-700">{{ $this->groupMaxSize }}</span> (including main registrant).
                                    </p>
                                </div>
                                @if($isGroupRegistration)
                                    @php
                                        $currentCount = count($groupMembers) + 1;
                                        $maxReached = $currentCount >= $this->groupMaxSize;
                                        $canAddMore = $currentCount < $this->groupMaxSize;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-lg">
                                            <span class="text-xs font-medium text-slate-600">Members:</span>
                                            <span class="text-sm font-semibold {{ $maxReached ? 'text-red-600' : 'text-teal-700' }}">
                                                {{ $currentCount }}/{{ $this->groupMaxSize }}
                                            </span>
                                        </div>
                                        <button type="button"
                                                wire:click="addGroupMember"
                                                wire:loading.attr="disabled"
                                                @if($maxReached) disabled @endif
                                                class="md:inline-flex hidden items-center gap-2 px-4 py-2 border {{ $maxReached ? 'border-slate-300 text-slate-400 cursor-not-allowed' : 'border-teal-500 text-teal-600 hover:bg-teal-50' }} rounded-lg text-sm font-semibold transition-colors disabled:opacity-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span wire:loading.remove wire:target="addGroupMember">
                                                {{ $maxReached ? 'Max Reached' : 'Add Member' }}
                                            </span>
                                            <span wire:loading wire:target="addGroupMember" class="inline-flex items-center gap-1">
                                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Adding...
                                            </span>
                                        </button>
                                        <div class="md:hidden flex flex-col justify-center items-center gap-1">
                                            <button type="button"
                                                    wire:click="addGroupMember"
                                                    wire:loading.attr="disabled"
                                                    @if($maxReached) disabled @endif
                                                    class="flex justify-center items-center p-3 shadow {{ $maxReached ? 'bg-slate-400 cursor-not-allowed' : 'bg-teal-700 hover:bg-teal-600' }} text-white rounded-full transition-colors disabled:opacity-50">
                                                <svg wire:loading.remove wire:target="addGroupMember" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                <svg wire:loading wire:target="addGroupMember" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                @forelse($groupMembers as $index => $member)
                                    <div 
                                        wire:key="group-member-{{ $index }}"
                                        x-data="{ open: @entangle('groupMembers.' . $index . '.showDetails') }"
                                        class="border border-slate-200 rounded-lg space-y-4"
                                    >
                                        <div x-on:click="open = !open" class="cursor-pointer flex md:items-center items-start justify-between bg-teal-600 hover:bg-teal-700 transition-all duration-300 border border-teal-700 rounded-t-lg text-white px-4 py-2">
                                            {{-- add a toggle show/hide the group member details --}}
                                            <div class="flex gap-2 md:items-center items-start">
                                                <p class="text-sm text-white font-medium">
                                                    <span class="sr-only" x-text="open ? 'Collapse member details' : 'Expand member details'"></span>
                                                    <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                                    </svg>
                                                    <svg x-show="!open" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </p>
                                                <h4 class="md:text-base text-sm font-semibold text-slate-100">
                                                    Group Member {{ $index + 2 }} 
                                                    <span class="capitalize font-light">{{ ($member['firstName']) ? ': '.$member['firstName'].' '.$member['lastName'] : '' }}</span>
                                                </h4>
                                            </div>
                                            <button type="button"
                                                    wire:click="removeGroupMember({{ $index }})"
                                                    class="text-sm text-white hover:text-white/80 font-medium hover:bg-teal-300/20 transition-all duration-300 rounded-full p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                            </button>
                                        </div>
                                        
                                        <div 
                                            x-cloak 
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                                            x-transition:enter-end="opacity-100 transform translate-y-0"
                                            x-transition:leave="transition ease-in duration-300"
                                            x-transition:leave-start="opacity-100 transform translate-y-0"
                                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                                            class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5 origin-top transform"
                                            style="display: none;"
                                        >
                                            <div class="md:w-1/2 w-full">
                                                <label class="block text-sm font-medium text-slate-600 mb-1">Title</label>
                                                <select 
                                                    wire:model.defer="groupMembers.{{ $index }}.title" 
                                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="">Select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Ms">Ms</option>
                                                    <option value="Dr">Dr</option>
                                                    <option value="Rev">Rev</option>
                                                </select>
                                                @error("groupMembers.$index.title") <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600 mb-1">NRIC <span class="text-slate-500 px-1">(Last 4-digit)</span></label>
                                                <input 
                                                    type="text" 
                                                    class="md:w-1/2 w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    wire:model.defer="groupMembers.{{ $index }}.nric"
                                                    placeholder="Last 4-digit (e.g. 1234)"
                                                    maxlength="4"
                                                >
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600 mb-1">First Name</label>
                                                <input 
                                                    type="text" 
                                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    wire:model.live="groupMembers.{{ $index }}.firstName"
                                                    placeholder="eg. John"
                                                >
                                                @error("groupMembers.$index.firstName") <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600 mb-1">Last Name</label>
                                                <input 
                                                    type="text" 
                                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    wire:model.live="groupMembers.{{ $index }}.lastName"
                                                    placeholder="eg. Doe"
                                                >
                                                @error("groupMembers.$index.lastName") <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                                                <input 
                                                    type="email" 
                                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    wire:model.defer="groupMembers.{{ $index }}.email"
                                                    placeholder="eg. john.doe@example.com"
                                                >
                                                @error("groupMembers.$index.email") <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="">
                                                <label class="block text-sm font-medium text-slate-600 mb-1">Contact Number</label>
                                                <div class="flex items-center gap-1">
                                                    <x-country-select 
                                                        wire:model.defer="groupMembers.{{ $index }}.country"
                                                        class="w-[100px] px-2 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        :required="false"
                                                        format="phonecode" 
                                                    />
    
                                                    <input type="text" 
                                                        wire:model.defer="groupMembers.{{ $index }}.contactNumber"
                                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        placeholder="eg. 123456789"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-slate-600 mb-1">Address</label>
                                                <input type="text" wire:model.defer="groupMembers.{{ $index }}.address" 
                                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                    placeholder="eg. 123 Main St"
                                                >
                                            </div>
                                            <div class="col-span-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-600 mb-1">City</label>
                                                    <input type="text" wire:model.defer="groupMembers.{{ $index }}.city" 
                                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        placeholder="eg. Kuala Lumpur"
                                                    >
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-600 mb-1">Postal Code</label>
                                                    <input type="text" wire:model.defer="groupMembers.{{ $index }}.postalCode" 
                                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                        placeholder="eg. 12345"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="!open" class="p-4" style="margin-top: 0rem !important;">
                                            <p class="capitalize font-light">{{ ($member['firstName']) ? 'Name: '.$member['firstName'].' '.$member['lastName'] : '' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-500 min-h-10 border border-slate-200 bg-slate-50 rounded-lg p-4">No additional members added yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <button type="button" wire:click="previousStep" class="flex items-center justify-center gap-1 bg-slate-100 text-slate-700 px-6 py-3 border border-slate-200 rounded-lg font-semibold hover:bg-slate-200 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </button>
                            <button type="button" wire:click="nextStep" class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 transition">
                                Continue
                            </button>
                        </div>
                    </div>
                @endif

                @if($hasActivePromocodes && $currentStepName === 'promo')
                    <div class="space-y-1">
                        <div class="space-y-6 bg-slate-100 border border-slate-200 rounded-lg p-4">
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800 mb-2">Promo Code</h3>
                                <p class="text-slate-600">Have a promo code? Enter it below.</p>
                            </div>

                            @if($promoMessage)
                                <p class="flex whitespace-nowrap mb-1 text-sm p-2 rounded-lg border {{ $promoError ? 'text-red-600 bg-red-50 border-red-300' : 'text-teal-600 bg-teal-50 border-teal-300' }}">
                                    {{ $promoMessage }}
                                </p>
                            @endif
    
                            <div class="md:flex md:items-center md:space-x-2 mb-0 md:w-1/2 w-full">
                                <div class="md:flex-1 w-full">
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Promo Code</label>
                                    <input type="text" 
                                        wire:model.defer="formData.promocode" 
                                        class="uppercase tracking-wide form-input w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="eg. PROMO10"
                                    >
                                </div>
                                <div>
                                    <button type="button"
                                            wire:click="applyPromocode"
                                            class="mt-4 md:mt-7 bg-slate-900 uppercase tracking-wide text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-700 transition">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br />
                        <br />
                        <br />

                        <div class="flex justify-between">
                            <button type="button" wire:click="previousStep" class="bg-slate-100 flex items-center justify-center gap-1 text-slate-700 px-6 py-3 rounded-lg font-semibold hover:bg-slate-200 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </button>
                            <button type="button" wire:click="nextStep" class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 transition">
                                Continue
                            </button>
                        </div>
                    </div>
                @endif

                @if($currentStepName === 'confirm')
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Review & Confirm</h3>
                            <p class="text-slate-600">Please review your details before submitting.</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="border border-slate-200 bg-slate-50 rounded-lg p-5 space-y-2">
                                <h4 class="text-base font-semibold text-slate-700 uppercase tracking-wide">
                                    {{ $isGroupRegistration ? 'Main Registrant' : 'Registrant Details' }}
                                </h4>
                                <p class="text-base text-slate-600 flex items-center">
                                    <svg class="w-4 h-4 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $formData['title'] }} {{ $formData['firstName'] }} {{ $formData['lastName'] }}
                                </p>
                                <p class="text-base text-slate-600 flex items-center">
                                    <svg class="w-4 h-4 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9 2.5 2.5 0 000-5z" />
                                    </svg>
                                    <span>{{ $formData['email'] }}</span>
                                </p>
                                <p class="text-base text-slate-600 flex items-center">
                                    <svg class="w-4 h-4 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                    <span>{{ collect([$formData['country'] ?? null, $formData['contactNumber'] ?? null])->filter()->implode(' ') }}</span>
                                </p>
                            </div>

                            <div class="border border-slate-200 rounded-lg p-5 space-y-3">
                                <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Pricing</h4>
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Standard Price</span>
                                    <span class="{{ ($selectedPromotion || $appliedPromocode) ? 'line-through text-slate-600' : '' }}">{{ $defaultPriceLabel }}</span>
                                </div>
                                @if($selectedPromotion)
                                    <div class="flex justify-between text-sm text-slate-600">
                                        <span>Promotion</span>
                                        <span>{{ $selectedPromotion ? $selectedPromotion->title : 'None' }}</span>
                                    </div>
                                @endif
                                @if($selectedPromotion && $promotionPriceLabel)
                                    <div class="flex justify-between text-sm text-slate-600">
                                        <span>Promotion Price</span>
                                        <span class="font-semibold text-green-600">{{ $promotionPriceLabel }}</span>
                                    </div>
                                @endif
                                @if($appliedPromocode)
                                    <div class="flex justify-between text-sm text-slate-600">
                                        <span>Promo Code</span>
                                        <span>{{ $appliedPromocode->promocode }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-slate-600">
                                        <span>Promocode Price</span>
                                        <span class="font-semibold text-green-600">{{ '$'.number_format(floatval($appliedPromocode->price), 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Admin Fee</span>
                                    @php
                                        $adminFee = floatval($programme->adminFee) <= 0 ? 0 : floatval($programme->adminFee);
                                    @endphp
                                    <span class="font-semibold text-slate-600">{{ '$'.number_format($adminFee, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-base font-semibold text-slate-800 border-t border-slate-200 pt-3">
                                    <span>Total</span>
                                    <span class="font-bold text-green-600">{{ $finalPrice !== null ? ($finalPrice <= 0 ? 'Free' : '$'.number_format($finalPrice, 2)) : $defaultPriceLabel }}</span>
                                </div>
                            </div>
                        </div>

                        @if($isGroupRegistration && count($groupMembers) > 0)
                            <div class="border border-slate-200 rounded-lg p-5 space-y-4">
                                <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Group Registration</h4>
                                <div class="space-y-2 text-sm text-slate-600">
                                    <div class="flex justify-between border-b border-slate-200 pb-2 last:border-none last:pb-0">
                                        <span>{{ '#1' }}. {{ $formData['title'] }} {{ $formData['firstName'] }} {{ $formData['lastName'] }} (You)</span>
                                        <span>{{ collect([$formData['country'] ?? null, $formData['contactNumber'] ?? null])->filter()->implode(' ') }}</span>
                                        <span>{{ $formData['email'] }}</span>
                                    </div>
                                    @foreach($groupMembers as $index => $member)
                                        <div class="flex justify-between border-b border-slate-200 pb-2 last:border-none last:pb-0">
                                            <span>{{ '#'. $index + 2 }}. {{ $member['title'] }} {{ $member['firstName'] }} {{ $member['lastName'] }}</span>
                                            <span>{{ collect([$member['country'] ?? null, $member['contactNumber'] ?? null])->filter()->implode(' ') }}</span>
                                            <span>{{ $member['email'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <button type="button" wire:click="previousStep" class="flex items-center justify-center gap-1 bg-slate-100 text-slate-700 px-6 py-3 border border-slate-200 rounded-lg font-semibold hover:bg-slate-200 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </button>
                            <button type="submit" class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 transition">
                                Complete Registration
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

