<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="font-medium md:text-lg text-base text-slate-500 uppercase tracking-wider mt-6">
                Additional & Custom Settings
            </p>
            <p class="font-normal text-sm text-slate-400 mb-6">
                Configure additional settings for your programme.
            </p>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    {{-- Invitation Only --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Turn on invitation only mode
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                Only to who has the registration link can register for the programme.
                            </p>
                        </td>
                        <td class="p-4 mt-4 flex md:justify-start justify-end">
                            <label for="invitationOnly" class="cursor-pointer select-none items-center">
                                <div 
                                    x-cloak
                                    x-data="{ isActive: @entangle('invitationOnly'), showToolTip: false }" 
                                    class="relative"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <input 
                                        wire:change="toogleInvitationOnly"
                                        wire:confirm="Are you sure you want to change the visibility setting of the programme?"
                                        wire:model="invitationOnly"
                                        type="checkbox" id="invitationOnly" class="sr-only flex" 
                                    />
                                    <p :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></p>
                                    <p :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></p>
                                    <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                        <p class="text-left text-xs text-white flex flex-col p-1">
                                            Invitation only mode
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                    {{-- Allow Pre-registration --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Allow Pre-registration
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                Allow participants to register for the programme before the programme starts. 
                                If not free, no payment is needed yet.
                            </p>
                        </td>
                        <td class="p-4 mt-4 flex md:justify-start justify-end">
                            <label for="toogleAllowPreRegistration" class="cursor-pointer select-none items-center">
                                <div 
                                    x-cloak
                                    x-data="{ isActive: @entangle('allowPreRegistration'), showToolTip: false }" 
                                    class="relative"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <input 
                                        wire:change="toogleAllowPreRegistration"
                                        wire:confirm="Are you sure you want to change the pre-registration setting of the programme?"
                                        wire:model="allowPreRegistration"
                                        type="checkbox" id="toogleAllowPreRegistration" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                        <p class="text-left text-xs text-white flex flex-col p-1">
                                            Allow pre-registration
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                    {{-- Allow Walk-in Registrations --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Allow Walk-in Registrations
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                Allow participants to register for the programme on the day of the programme.
                            </p>
                        </td>
                        <td class="p-4 mt-4 flex md:justify-start justify-end">
                            <label for="toogleAllowWalkInRegistration" class="cursor-pointer select-none items-center">
                                <div 
                                    x-cloak
                                    x-data="{ isActive: @entangle('allowWalkInRegistration'), showToolTip: false }" 
                                    class="relative"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <input 
                                        wire:change="toogleAllowWalkInRegistration"
                                        wire:confirm="Are you sure you want to change the walk-in registration setting of the programme?"
                                        wire:model="allowWalkInRegistration"
                                        type="checkbox" id="toogleAllowWalkInRegistration" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                        <p class="text-left text-xs text-white flex flex-col p-1">
                                            Allow walk-in registrations
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                    {{-- Enable Breakout Sessions --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Enable Breakout Sessions
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                Enable breakout sessions for the programme.
                            </p>
                        </td>
                        <td class="p-4 mt-4 flex md:justify-start justify-end">
                            <label for="toogleEnableBreakoutSession" class="cursor-pointer select-none items-center">
                                <div 
                                    x-cloak
                                    x-data="{ isActive: @entangle('allowBreakoutSession'), showToolTip: false }" 
                                    class="relative"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <input 
                                        wire:change="toogleAllowBreakoutSession"
                                        wire:confirm="Are you sure you want to change the breakout session setting of the programme?"
                                        wire:model="allowBreakoutSession"
                                        type="checkbox" id="toogleEnableBreakoutSession" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                        <p class="text-left text-xs text-white flex flex-col p-1">
                                            Enable breakout sessions
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                    {{-- Make it searchable --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Make it searchable
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                Make the programme searchable in the search feature.
                            </p>
                        </td>
                        <td class="p-4 flex md:justify-start justify-end">
                            <label for="toogleSearchable" class="cursor-pointer select-none items-center">
                                <div 
                                    x-cloak
                                    x-data="{ isActive: @entangle('searchable'), showToolTip: false }" 
                                    class="relative"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <input 
                                        wire:change="toogleSearchable"
                                        wire:confirm="Are you sure you want to change the search setting of the programme?"
                                        wire:model="searchable"
                                        type="checkbox" id="toogleSearchable" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                        <p class="text-left text-xs text-white flex flex-col p-1">
                                            Make it searchable
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                    {{-- Make it Publishable --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Make it publishable
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                Make the programme publishable in the system.
                                It will be visible to the public in the search feature.
                            </p>
                        </td>
                        <td class="p-4 mt-4 flex md:justify-start justify-end">
                            <label for="toggle6" class="cursor-pointer select-none items-center">
                                <div 
                                    x-cloak
                                    x-data="{ isActive: @entangle('publishable'), showToolTip: false }" 
                                    class="relative"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <input 
                                        wire:change="tooglePublishable"
                                        wire:confirm="Are you sure you want to change the visibility setting of the programme?"
                                        wire:model="publishable"
                                        type="checkbox" id="toggle6" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                        <p class="text-left text-xs text-white flex flex-col p-1">
                                            Make it publishable
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </td>
                    </tr>
                    {{-- Admin Fee --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Admin Fee <span class="italic text-xs text-slate-500">(SGD)</span>
                            <p class="text-xs italic text-slate-500 text-left leading-4">
                                The admin fee for the programme. This will be added & reflected from the total amount paid by the participant in the checkout page.
                            </p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex md:justify-start justify-end">
                            <div class="relative" x-show="!showEdit">
                                <p class="flex gap-2 items-center">
                                    {{ '$ '.number_format($programme->adminFee, 2) }}
                                    <svg 
                                        @mouseover="showToolTip=true" 
                                        @mouseleave="showToolTip=false"
                                        @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </p>
                                <div x-show="showToolTip" x-transition class="absolute top-6 -right-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                    Edit
                                </div>
                            </div>
                            <div x-show="showEdit" class="flex">
                                <input 
                                    type="number"
                                    wire:model.live.debounce.500ms="adminFee"
                                    step="0.10" 
                                    class="group w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                    placeholder="SGD 0.00" 
                                />
                                <div class="flex gap-3 items-center">
                                    <svg 
                                        wire:click="updateProgrammeInfo('adminFee', {{$adminFee}}), showEdit=false" 
                                        wire:confirm="Are you sure to make this changes?"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500 hover:stroke-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- Incharge Email Address --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Incharge Email Address
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                The email address of the incharge of the programme. This will be used to send the registration confirmation email to the participant.
                            </p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex md:justify-start justify-end">
                            <div x-show="!showEdit" class="relative">
                                <p class="flex gap-2 items-center">
                                    {{ $programme->contactEmail }}
                                    <svg 
                                        @mouseover="showToolTip=true" 
                                        @mouseleave="showToolTip=false"
                                        @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <div x-show="showToolTip" x-transition class="absolute top-6 -right-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                        Edit
                                    </div>
                                </p>
                            </div>
                            <div x-show="showEdit" class="flex gap-2 w-full">
                                <input 
                                    type="email" 
                                    wire:model.live.debounce.500ms="contactEmail"
                                    class="group w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                    placeholder="Incharge Email Address" 
                                />
                                <div class="flex gap-3 items-center">
                                    <svg 
                                        wire:click="updateProgrammeInfo('contactEmail', '{{$contactEmail}}'), showEdit=false" 
                                        wire:confirm="Are you sure to make this changes?"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500 hover:stroke-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- Cheque Code --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Cheque Code
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                The cheque code for the programme. This will be used to identify the cheque payment for the programme.
                            </p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex md:justify-start justify-end">
                            <div x-show="!showEdit" class="relative">
                                <p class="flex gap-2 items-center">
                                    {{ $programme->chequeCode }}
                                    <svg 
                                        @mouseover="showToolTip=true" 
                                        @mouseleave="showToolTip=false"
                                        @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <div x-show="showToolTip" x-transition class="absolute top-6 -right-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                        Edit
                                    </div>
                                </p>
                            </div>
                            <div x-show="showEdit" class="flex">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.500ms="chequeNumber"
                                    class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                    placeholder="Cheque Code" 
                                />
                                <div class="flex gap-3 items-center">
                                    <svg 
                                        wire:click="updateProgrammeInfo('chequeCode', '{{$chequeNumber}}'), showEdit=false" 
                                        wire:confirm="Are you sure to make this changes?"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500 hover:stroke-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- Limit maximum registrant --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Limit maximum registrant
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                The maximum number of registrants for the programme.
                            </p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex md:justify-start justify-end">
                            <div x-show="!showEdit" class="relative">
                                <p class="flex gap-2 items-center">
                                    {{ $programme->limit > 0 ? $programme->limit . ' maximum participants' : 'No limit' }}
                                    <svg 
                                        @mouseover="showToolTip=true" 
                                        @mouseleave="showToolTip=false"
                                        @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <div x-show="showToolTip" x-transition class="absolute top-6 -right-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                        Edit
                                    </div>
                                </p>
                            </div>
                            <div x-show="showEdit" class="flex">
                                <input 
                                    type="number" 
                                    wire:model.live.debounce.500ms="limit"
                                    step="1" 
                                    class="w-full rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                    placeholder="Max Registrant" 
                                />
                                <div class="flex gap-3 items-center">
                                    <svg 
                                        wire:click="updateProgrammeInfo('limit', '{{$limit}}'), showEdit=false" 
                                        wire:confirm="Are you sure to make this changes?"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500 hover:stroke-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- External Registration Link --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            External Registration Link
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                The external registration link for the programme. This will be used to redirect the participant to the external registration page.
                            </p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex md:justify-start justify-end">
                            <div x-show="!showEdit" class="relative">
                                <p class="flex gap-2 items-center">
                                    {!! $programme->externalUrl > 0 ? '<a target="_blank" class="text-blue-500 hover:text-blue-700 duration-300" href="'.$programme->externalUrl.'">'.Str::limit($programme->externalUrl, 30, '...').'</a>' : 'No External Registration Link' !!}
                                    <svg 
                                        @mouseover="showToolTip=true" 
                                        @mouseleave="showToolTip=false"
                                        @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <div x-show="showToolTip" x-transition class="absolute top-6 -right-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                        Edit
                                    </div>
                                </p>
                            </div>
                            <div x-show="showEdit" class="flex w-full">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.500ms="externalUrl"
                                    class="rounded-md w-full border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" placeholder="https://invitation-link-here.com" 
                                />
                                <div class="flex gap-3 items-center">
                                    <svg 
                                        wire:click="updateProgrammeInfo('externalUrl', '{{$externalUrl}}'), showEdit=false" 
                                        wire:confirm="Are you sure to make this changes?"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500 hover:stroke-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- Registration validity period --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4 text-nowrap">Registration validity period 
                            <p class="text-xs italic text-slate-500">Set the validity period for the registration of the programme.</p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex">
                            <div x-show="!showEdit" class="relative">
                                <p class="flex gap-2 items-center text-nowrap">
                                    {{ Carbon\Carbon::parse($programme->activeUntil)->format('F j, Y - g:i A')}}
                                    <svg 
                                        @mouseover="showToolTip=true" 
                                        @mouseleave="showToolTip=false"
                                        @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <div x-show="showToolTip" x-transition class="absolute top-6 -right-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                        Edit
                                    </div>
                                </p>
                            </div>
                            <div x-show="showEdit" class="flex gap-2 w-full">
                                <input 
                                    type="datetime-local" 
                                    wire:model.live.debounce.500ms="activeUntil"
                                    class="w-full rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" placeholder="https://invitation-link-here.com" 
                                />
                                <div class="flex gap-3 items-center">
                                    <svg 
                                        wire:click="updateProgrammeInfo('activeUntil', '{{$activeUntil}}'), showEdit=false" 
                                        wire:confirm="Are you sure to make this changes?"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500 hover:stroke-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>

                        </td>
                    </tr>
                    {{-- allow Group Registration --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Allow Group Registration
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                The allow group registration for the programme.
                            </p>
                        </td>
                        <td class="p-4 flex md:justify-start justify-end">
                            <div x-cloak x-data="{showToolTip:false, isActive: @entangle('allowGroupRegistration')}" class="relative">
                                <label for="allowGroupRegistration" class="cursor-pointer select-none items-center">
                                    <div 
                                        class="relative"
                                        wire:click="toogleAllowGroupRegistration"
                                        @mouseover="showToolTip = true" 
                                        @mouseleave="showToolTip = false"
                                    >
                                        <input 
                                            wire:model.live.debounce.500ms="allowGroupRegistration"
                                            type="checkbox" id="allowGroupRegistration" class="sr-only flex" 
                                        />
                                        <p :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></p>
                                        <p :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></p>
                                        <div x-show="showToolTip" x-transition class="absolute mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-700 rounded px-2 py-1 shadow-lg z-50">
                                            <p class="text-left text-xs text-white flex flex-col p-1">
                                                Allow group registration
                                            </p>
                                        </div>
                                    </div>
                                </label>
                                <div x-show="isActive" class="border border-slate-400 p-2 rounded-md mt-3">
                                    <p class="text-xs italic text-slate-500 text-left mt-1 leading-4 my-2">Setup the group registration settings for the programme.</p>
                                    <div class="flex gap-2">
                                        <div class="w-18">
                                            <label for="groupRegistrationMin" class="text-xs italic text-slate-500 text-left leading-4 my-2">Min Reg</label>
                                            <input 
                                                type="number" 
                                                wire:model.live.debounce.500ms="groupRegistrationMin"
                                                class="w-18 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                                placeholder="Minimum Registrant" 
                                            />
                                        </div>
                                        <div class="w-18">
                                            <label for="groupRegistrationMax" class="text-xs italic text-slate-500 text-left leading-4 my-2">Max Reg</label>
                                            <input 
                                                type="number" 
                                                wire:model.live.debounce.500ms="groupRegistrationMax"
                                                class="w-18 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                                placeholder="Maximum Registrant" 
                                            />
                                        </div>
                                        <div class="w-18">
                                            <label for="groupRegistrationMax" class="text-xs italic text-slate-500 text-left leading-4 my-2">Fee</label>
                                            <input 
                                                type="number" 
                                                wire:model.live.debounce.500ms="groupRegistrationFee"
                                                class="w-18 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                                                placeholder="Fee/member" 
                                            />
                                        </div>
                                        <div class="flex justify-end items-center pt-6">
                                            <button 
                                            wire:click="saveGroupRegistrationSettings" 
                                            wire:confirm="Are you sure to make this changes?"
                                            class="flex justify-end items-center bg-blue-600 text-white px-4 py-3 text-xs rounded-md hover:bg-blue-700 duration-300">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- Status --}}
                    <tr class="border border-slate-400 p-4">
                        <td class="p-4">
                            Status
                            <p class="text-xs italic text-slate-500 text-left mt-1 leading-4">
                                The status of the programme.
                            </p>
                        </td>
                        <td x-cloak x-data="{showEdit:false, showToolTip:false}" class="p-4 flex md:justify-start justify-end" :class="{'flex-col gap-3': showEdit}">
                            <div x-show="!showEdit" class="relative">
                                <p class="flex gap-2 items-center">
                                @php
                                    $statusColor = match($programme->status) {
                                        'published' => 'border-green-500 bg-green-500/90',
                                        'unpublished' => 'border-red-500 bg-red-500/90',
                                        'pending' => 'border-yellow-500 bg-yellow-500/90',
                                        'draft' => 'border-slate-500 bg-slate-500/90',
                                    };
                                @endphp
                                <span 
                                    class="{{ $statusColor }} border text-sm text-slate-100 drop-shadow rounded-md px-2 capitalize tracking-wider">{{$programme->status}}</span>
                                <svg 
                                    @mouseover="showToolTip=true" 
                                    @mouseleave="showToolTip=false"
                                    @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                <div x-show="showToolTip" x-transition class="absolute top-6 left-20 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                    Edit
                                </div>
                            </div>
                            <div x-show="showEdit" class="flex flex-col gap-3">
                                <label class="flex gap-3 items-center">
                                    <input 
                                        type="radio" 
                                        wire:model="programmeStatus" 
                                        value="published" 
                                    />
                                    <span class="border border-green-500 bg-green-500/90 text-sm text-slate-100 drop-shadow rounded-md px-2">Publish</span>
                                </label>
                                <label class="flex gap-3 items-center">
                                    <input 
                                        type="radio" 
                                        wire:model="programmeStatus" 
                                        value="unpublished" 
                                    />
                                    <span class="border border-red-500 bg-red-500/90 text-sm text-slate-100 drop-shadow rounded-md px-2">Unpublished</span>
                                </label>
                                <label class="flex gap-3 items-center">
                                    <input 
                                        type="radio" 
                                        wire:model="programmeStatus" 
                                        value="draft" 
                                    />
                                    <span class="border border-slate-500 bg-slate-500 text-sm text-slate-100 drop-shadow rounded-md px-2">Draft</span>
                                </label>
                                <label class="flex gap-3 items-center">
                                    <input 
                                        type="radio" 
                                        wire:model="programmeStatus" 
                                        value="pending" 
                                    />
                                    <span class="border border-yellow-500 bg-yellow-500/90 text-sm text-slate-100 drop-shadow rounded-md px-2">Pending</span>
                                </label>
                            </div>
                            <div x-show="showEdit" class="flex gap-3 items-center">
                                <svg 
                                    wire:click="confirmedStatusChange, showEdit=false" 
                                    wire:confirm="Are you sure to make this changes?"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="showEdit=false" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>