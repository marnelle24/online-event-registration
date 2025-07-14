<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex justify-between items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="font-medium text-md text-slate-500">
                Additional & Custom Settings
            </p>
        </div>
        <div class="border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            {{-- @dump($programmeId) --}}
            {{-- @dump($programme->getAttributes()) --}}
            <table class="w-full">
                <tr>
                    <td width="25%" class="py-2">Turn on invitation only mode</td>
                    <td class="p-2 w-14 flex">
                        <label for="toggle4" class="cursor-pointer select-none items-center">
                            <div x-data="{ isActive: @entangle('invitationOnly') }" class="relative">
                                <input 
                                    wire:change="toogleInvitationOnly"
                                    wire:confirm="Are you sure you want to change the visibility setting of the programme?"
                                    wire:model="invitationOnly"
                                    type="checkbox" id="toggle4" class="sr-only flex" 
                                />
                                <p :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></p>
                                <p :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></p>
                            </div>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">Make it searchable</td>
                    <td class="p-2 w-14 flex">
                        <label for="toggle5" class="cursor-pointer select-none items-center">
                            <div x-data="{ isActive: @entangle('searchable') }" class="relative">
                                <input 
                                    wire:change="toogleSearchable"
                                    wire:confirm="Are you sure you want to change the search setting of the programme?"
                                    wire:model="searchable"
                                    type="checkbox" id="toggle5" class="sr-only" />
                                <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                            </div>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">Make it publishable</td>
                    <td class="p-2 w-14 flex">
                        <label for="toggle6" class="cursor-pointer select-none items-center">
                            <div x-data="{ isActive: @entangle('publishable') }" class="relative">
                                <input 
                                    wire:change="tooglePublishable"
                                    wire:confirm="Are you sure you want to change the visibility setting of the programme?"
                                    wire:model="publishable"
                                    type="checkbox" id="toggle6" class="sr-only" />
                                <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                            </div>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="pt-6 pb-2">
                        Admin Fee <span class="italic text-sm text-slate-600">(SGD)</span>
                    </td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="pt-6 pb-2 flex gap-2 relative">
                        <p x-show="!showEdit" class="flex gap-2 items-center">
                            {{ 'SGD '.number_format($programme->adminFee, 2) }}
                            <svg 
                                @mouseover="showToolTip=true" 
                                @mouseleave="showToolTip=false"
                                @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <div x-show="showToolTip" x-transition class="absolute top-12 left-18 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                Edit
                            </div>
                        </p>
                        <div x-show="showEdit" class="flex gap-2">
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
                <tr>
                    <td width="25%" class="py-2">
                        Incharge Email Address
                    </td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="p-2 w-full flex relative">
                        <p x-show="!showEdit" class="flex gap-2 items-center">
                            {{ $programme->contactEmail }}
                            <svg 
                                @mouseover="showToolTip=true" 
                                @mouseleave="showToolTip=false"
                                @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <div x-show="showToolTip" x-transition class="absolute top-7.5 left-52 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                Edit
                            </div>
                        </p>
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
                <tr>
                    <td width="25%" class="py-2">
                        Cheque Code
                        <p class="text-xs italic text-slate-500">(Check code for cheque payments)</p>
                    </td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="p-2 w-full flex relative">
                        <p x-show="!showEdit" class="flex gap-2 items-center">
                            {{ $programme->chequeCode }}
                            <svg 
                                @mouseover="showToolTip=true" 
                                @mouseleave="showToolTip=false"
                                @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <div x-show="showToolTip" x-transition class="absolute top-7.5 left-24 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                Edit
                            </div>
                        </p>
                        <div x-show="showEdit" class="flex gap-2 w-full">
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
                <tr>
                    <td width="25%" class="py-2">Adjust maximum registrant</td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="p-2 w-full flex relative">
                        <p x-show="!showEdit" class="flex gap-2 items-center relative">
                            {{ $programme->limit > 0 ? $programme->limit . ' maximum participants' : 'No limit' }}
                            <svg 
                                @mouseover="showToolTip=true" 
                                @mouseleave="showToolTip=false"
                                @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <div x-show="showToolTip" x-transition class="absolute top-7.5 left-52 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                Edit
                            </div>
                        </p>
                        <div x-show="showEdit" class="flex gap-2 w-full">
                            <input 
                                type="number" 
                                wire:model.live.debounce.500ms="limit"
                                step="1" 
                                class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
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
                <tr>
                    <td width="25%" class="py-2">External Registration Link</td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="p-2 w-full flex relative">
                        <p x-show="!showEdit" class="flex gap-2 items-center relative">
                            {!! $programme->externalUrl > 0 ? '<a target="_blank" class="text-blue-500 hover:text-blue-700 duration-300" href="'.$programme->externalUrl.'">'.Str::limit($programme->externalUrl, 30, '...').'</a>' : 'No External Registration Link' !!}
                            <svg 
                                @mouseover="showToolTip=true" 
                                @mouseleave="showToolTip=false"
                                @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <div x-show="showToolTip" x-transition class="absolute top-7.5 left-64 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                Edit
                            </div>
                        </p>
                        <div x-show="showEdit" class="flex gap-2 w-full">
                            <input 
                                type="text" 
                                wire:model.live.debounce.500ms="externalUrl"
                                class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" placeholder="https://invitation-link-here.com" 
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
                <tr>
                    <td width="25%" class="py-2">Registration validity period 
                        <p class="text-xs italic text-slate-500">(Adjust active until date)</p>
                    </td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="p-2 w-full flex gap-2 relative">
                        <p x-show="!showEdit" class="flex gap-2 items-center relative">
                            {{ Carbon\Carbon::parse($programme->activeUntil)->format('F j, Y - g:i a')}}
                            <svg 
                                @mouseover="showToolTip=true" 
                                @mouseleave="showToolTip=false"
                                @click="showEdit=true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-slate-600/50 hover:stroke-blue-600 cursor-pointer hover:scale-110 duration-300 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <div x-show="showToolTip" x-transition class="absolute top-7.5 left-56 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                Edit
                            </div>
                        </p>
                        <div x-show="showEdit" class="flex gap-2 w-full">
                            <input 
                                type="datetime-local" 
                                wire:model.live.debounce.500ms="activeUntil"
                                class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" placeholder="https://invitation-link-here.com" 
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
                <tr>
                    <td width="25%" class="py-4 flex item">Status</td>
                    <td x-data="{showEdit:false, showToolTip:false}" class="p-4 w-full relative">
                        <div x-show="!showEdit" class="flex gap-2 items-center relative">
                            <span 
                                class="{{ $programme->status === 'published' ? 'border-green-500 bg-green-500/90' : '' }} {{ $programme->status === 'unpublished' ? 'border-red-500 bg-red-500/90' : '' }} {{ $programme->status === 'draft' ? 'border-slate-500 bg-slate-500/90' : '' }} border text-sm text-slate-100 drop-shadow rounded-md px-2 capitalize tracking-wider">{{$programme->status}}</span>
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
                        </div>
                        <div x-show="showEdit" class="flex gap-3 items-center mt-2">
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