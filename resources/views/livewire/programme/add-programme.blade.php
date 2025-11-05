<div class="relative" x-data="{ show: false }" @close-modal.window="show = false">
    <button 
        @click="show = true" 
        class="flex items-center gap-2 shadow border border-blue-600/30 bg-slate-600 drop-shadow text-slate-200 hover:bg-slate-700 rounded-full hover:-translate-y-0.5 duration-300 py-2 px-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New Programme
    </button>

    <!-- Backdrop and Slide-over Modal -->
    <div 
        x-cloak
        x-show="show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-hidden"
        x-cloak
        @keydown.escape="show = false">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity"
             @click="show = false"></div>
             
        <!-- Slide Panel -->
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-full max-w-2xl bg-white shadow-xl"
        >
                
            <div class="flex h-full flex-col">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Add Programme</h2>
                    <button 
                        @click="show = false" 
                        class="text-slate-600 hover:text-slate-900 text-xl p-2 rounded-full hover:bg-slate-300/50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-white hover:stroke-slate-200 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <x-validation-errors :class="'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md'" />
                    
                    @if (session()->has('message'))
                        <div class="mb-4 text-green-700 bg-green-300/40 border border-green-600/20 rounded-md p-3 text-sm">
                            {{ session('message') }}
                        </div> 
                    @endif
                    
                    <form wire:submit.prevent="save" class="flex flex-col gap-4">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Create a new programme or event for your organization.
                                This programme can be assigned to ministries and categories.
                            </p>
                        </div>
                        
                        <div class="space-y-4 flex flex-col">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-3 col-span-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Ministry -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Ministry<span class="text-red-500 px-1">*</span></label>
                                        <select wire:model="ministry_id" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary">
                                            <option value="">Select Ministry</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{ $ministry->id }}">{{ $ministry->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ministry_id')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
    
                                    <!-- Programme Code -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Programme Code<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="programmeCode"
                                            type="text" 
                                            placeholder="Example: PRG-XXXX" 
                                            class="placeholder:text-slate-300 focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />  
                                        @error('programmeCode')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Type -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Type<span class="text-red-500 px-1">*</span></label>
                                    <select wire:model="type" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary">
                                        @foreach($types as $type => $label)
                                            <option value="{{ $type }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Title -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Programme Title<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="title"
                                    type="text" 
                                    placeholder="Enter programme title" 
                                    class="placeholder:text-slate-300 focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- add description --}}
                            <div>
                                <label class="block text-sm font-medium text-black">Description</label>
                                <textarea 
                                    wire:model="description"
                                    rows="4"
                                    placeholder="About the programme..." 
                                    class="placeholder:text-slate-300 focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"
                                ></textarea>
                                @error('description')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- add excerpt --}}
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Excerpt</label>
                                <textarea 
                                    wire:model="excerpt"
                                    rows="2"
                                    placeholder="Excerpt of the programme..." 
                                    class="placeholder:text-slate-300 focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"
                                ></textarea>
                                @error('excerpt')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Dates and Times -->
                            <div>
                                <p class="text-sm text-slate-500 font-bold mb-1">Schedule Details</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-md border border-slate-300/60 bg-slate-50">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Start Date -->
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-black">Start Date<span class="text-red-500 px-1">*</span></label>
                                            <input 
                                                wire:model="startDate"
                                                type="date" 
                                                class="focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            />
                                            @error('startDate')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
        
                                        <!-- End Date -->
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-black">End Date</label>
                                            <input 
                                                wire:model="endDate"
                                                type="date" 
                                                class="focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            />
                                            @error('endDate')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Start Time -->
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-black">Start Time<span class="text-red-500 px-1">*</span></label>
                                            <input 
                                                wire:model="startTime"
                                                type="time" 
                                                class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            />
                                            @error('startTime')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
        
                                        <!-- End Time -->
                                        <div>
                                            <label class="mb-1 block text-sm font-medium text-black">End Time</label>
                                            <input 
                                                wire:model="endTime"
                                                type="time" 
                                                class="focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            />
                                            @error('endTime')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- add custom date --}}
                                    <div class="col-span-2 w-full">
                                        <label class="mb-1 block text-sm font-medium text-black">Or, Alternative Date</label>
                                        <textarea    
                                            wire:model="customDate"
                                            rows="2"
                                            placeholder="Alternative content to display a date in landing page." 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        ></textarea>
                                        @error('customDate')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>  
                                </div>
                            </div>

                            <!-- Location -->
                            <div>
                                <p class="text-sm text-slate-500 font-bold mb-1">Venue & Platform Details</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-md border border-slate-300/60 bg-slate-50">
                                    <div class="col-span-2">
                                        <label class="mb-1 block text-sm font-medium text-black">Address<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="address"
                                            type="text" 
                                            placeholder="Address" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('address')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">City<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="city"
                                            type="text" 
                                            placeholder="City" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('city')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">State<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="state"
                                            type="text" 
                                            placeholder="State" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('state')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Postal Code<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="postalCode"
                                            type="text" 
                                            placeholder="Example: 123456" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('postalCode')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     <div>
                                         <label class="mb-1 block text-sm font-medium text-black">Country<span class="text-red-500 px-1">*</span></label>
                                        <x-country-select 
                                            wire:model="country"
                                            :selected="$country"
                                            name="country"
                                            id="country"
                                            class="w-full p-2 border rounded bg-white"
                                            :required="false"
                                            :withFlags="true"
                                            :withCode="false"
                                            :withPhoneCode="true"
                                        />
                                        @error('country')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                     </div>

                                      <!-- Hybrid Mode -->
                                      <div class="col-span-2">
                                           <label class="flex items-center gap-2">
                                               <input 
                                                 wire:model.live="isHybridMode"
                                                 type="checkbox" 
                                                 class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                               />
                                               <span class="text-sm font-medium text-black">Online and/or Hybrid</span>
                                           </label>
                                         @if($isHybridMode)
                                             <div class="flex flex-col gap-2 mt-2 w-full">
                                                 <label class="block text-sm font-medium text-black">Platform Details (Zoom, Teams, etc.)</label>
                                                 <textarea 
                                                     wire:model="hybridPlatformDetails"
                                                     rows="3"
                                                     placeholder="Enter platform details (e.g., Zoom link: https://zoom.us/j/123456789, Meeting ID: 123 456 7890)"
                                                     class="focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary resize-none"
                                                 ></textarea>
                                                 @error('hybridPlatformDetails')
                                                     <span class="text-red-500 text-xs">{{ $message }}</span>
                                                 @enderror
                                             </div>
                                         @endif
                                     </div>
                                </div>
                            </div>

                            <!-- Contact Details -->
                            <div>
                                <p class="text-sm text-slate-500 font-bold mb-1">Contact Details</p>
                                <div class="grid grid-cols-1 gap-4 p-4 rounded-md border border-slate-300/60 bg-slate-50">
                                    <!-- Contact Person -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Person in-charge<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="contactPerson"
                                            type="text" 
                                            placeholder="Person in-charge" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('contactPerson')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
        
                                    <!-- Contact Number -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Contact Number<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="contactNumber"
                                            type="tel" 
                                            placeholder="Example: +65 1234 5678" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('contactNumber')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
        
                                    <!-- Contact Email -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Contact Email<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            wire:model="contactEmail"
                                            type="email" 
                                            placeholder="Example: john.doe@example.com" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('contactEmail')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div>
                                <p class="text-sm text-slate-500 font-bold mb-1">Pricing</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-md border border-slate-300/60 bg-slate-50">
                                    
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Cheque Code(for cheque payments)</label>
                                        <input 
                                            wire:model="chequeCode"
                                            type="text" 
                                            placeholder="Cheque Code" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('chequeCode')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Maximum Limit Registration</label>
                                        <input 
                                            wire:model="limit"
                                            type="number" 
                                            placeholder="Maximum Limit Registration" 
                                            class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @error('limit')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Price -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Price<span class="text-red-500 px-1">*</span></label>
                                        <div class="relative">
                                            <div class="absolute text-slate-400 font-bold inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                {{ $currency }}
                                            </div>
                                            <input 
                                                wire:model="price"
                                                type="number" 
                                                step="0.10"
                                                min="0"
                                                placeholder="0.00" 
                                                class="placeholder:text-slate-300 focus:ring-0 bg-white w-full pl-6 rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            />
                                        </div>
                                        @error('price')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
    
                                    <!-- Admin Fee -->
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Admin Fee</label>
                                        <div class="relative">
                                            <div class="absolute text-slate-400 font-bold inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                {{ $currency }}
                                            </div>
                                            <input 
                                                wire:model="adminFee"
                                                type="number" 
                                                step="0.10"
                                                min="0"
                                                placeholder="0.00" 
                                                class="placeholder:text-slate-300 focus:ring-0 bg-white w-full pl-6 rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            />
                                        </div>
                                        @error('adminFee')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <!-- Thumbnail -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">
                                    Thumbnail &nbsp;
                                    <span class="text-xs text-slate-500 italic">PNG, JPG or JPEG</span>
                                    <span class="text-xs text-slate-500 italic">(max, 400 X 300px) or 1.5MB</span>
                                </label>
                                <div class="flex flex-col gap-2 border border-dashed border-slate-300 bg-slate-50 rounded-md p-2">
                                    <input 
                                        wire:model="thumbnail"
                                        type="file" 
                                        accept="image/*"
                                        class="focus:ring-0 w-full bg-red-500 rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('thumbnail')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <p class="text-sm text-slate-500 font-bold mb-1">Additional Settings</p>
                                <div class="p-4 flex md:flex-row flex-col gap-4 rounded-md border border-slate-300/60 bg-slate-50">
                                    <div class="md:w-1/2 w-full flex flex-col gap-2">
                                        <div class="flex flex-col gap-2">
                                            <label for="searchable" class="flex cursor-pointer select-none items-center" x-data="{ searchable: @entangle('searchable') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="searchable"
                                                        type="checkbox" id="searchable" class="sr-only" />
                                                    <div :class="searchable && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="searchable && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Searchable</span>
                                            </label>
                                            <label for="publishable" class="flex cursor-pointer select-none items-center" x-data="{ publishable: @entangle('publishable') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="publishable"
                                                        type="checkbox" id="publishable" class="sr-only" />
                                                    <div :class="publishable && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="publishable && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Publishable</span>
                                            </label>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="private_only" class="flex cursor-pointer select-none items-center" x-data="{ private_only: @entangle('private_only') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="private_only"
                                                        type="checkbox" id="private_only" class="sr-only" />
                                                    <div :class="private_only && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="private_only && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Private Only</span>
                                            </label>
                                            <label for="allowPreRegistration" class="flex cursor-pointer select-none items-center" x-data="{ allowPreRegistration: @entangle('allowPreRegistration') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="allowPreRegistration"
                                                        type="checkbox" id="allowPreRegistration" class="sr-only" />
                                                    <div :class="allowPreRegistration && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="allowPreRegistration && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Allow Pre-Registration</span>
                                            </label>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label for="allowWalkInRegistration" class="flex cursor-pointer select-none items-center" x-data="{ allowWalkInRegistration: @entangle('allowWalkInRegistration') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="allowWalkInRegistration"
                                                        type="checkbox" id="allowWalkInRegistration" class="sr-only" />
                                                    <div :class="allowWalkInRegistration && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="allowWalkInRegistration && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Allow Walk-In Registration</span>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="md:w-1/2 w-full flex-col gap-2">
                                        <div class="flex flex-col gap-2">
                                            <label for="allowBreakoutSession" class="flex cursor-pointer select-none items-center" x-data="{ allowBreakoutSession: @entangle('allowBreakoutSession') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="allowBreakoutSession"
                                                        type="checkbox" id="allowBreakoutSession" class="sr-only" />
                                                    <div :class="allowBreakoutSession && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="allowBreakoutSession && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Allow Breakout Session</span>
                                            </label>
                                            <label for="allowGroupReg" class="flex cursor-pointer select-none items-center" x-data="{ allowGroupRegistration: @entangle('allowGroupRegistration') }">
                                                <div class="relative">
                                                    <input 
                                                        wire:model="allowGroupRegistration"
                                                        type="checkbox" id="allowGroupReg" class="sr-only" />
                                                    <div :class="allowGroupRegistration && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                                    <div :class="allowGroupRegistration && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                                </div>
                                                <span class="text-base font-normal text-black ml-1">Allow Group Registration</span>
                                            </label>
                                            <!-- Group Registration Settings -->
                                            <div x-show="$wire.allowGroupRegistration" 
                                                x-cloak
                                                class="col-span-2"
                                                x-transition:enter="transition ease-out duration-500" 
                                                x-transition:enter-start="opacity-0 transform translate-y-8" 
                                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                                x-transition:leave="transition ease-in duration-300"
                                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                                x-transition:leave-end="opacity-0 transform translate-y-8"
                                            >
                                                <div class="col-span-2 p-4 bg-slate-100 rounded-md border border-slate-300">
                                                    <p class="text-sm font-medium text-black mb-3">Group Registration Settings</p>
                                                    <div class="flex flex-col gap-2">
                                                        <!-- Group Registration Min -->
                                                        <div class="w-full">
                                                            <label class="mb-1 block text-sm font-medium text-black">Min Group Size<span class="text-red-500 px-1">*</span></label>
                                                            <input 
                                                                wire:model="groupRegistrationMin"
                                                                type="number" 
                                                                min="2"
                                                                placeholder="2" 
                                                                class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                                            />
                                                            @error('groupRegistrationMin')
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        
                                                        <!-- Group Registration Max -->
                                                        <div class="w-full">
                                                            <label class="mb-1 block text-sm font-medium text-black">Max Group Size<span class="text-red-500 px-1">*</span></label>
                                                            <input 
                                                                wire:model="groupRegistrationMax"
                                                                type="number" 
                                                                min="2"
                                                                placeholder="10" 
                                                                class="placeholder:text-slate-300 focus:ring-0 bg-white w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                                            />
                                                            @error('groupRegistrationMax')
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        
                                                        <!-- Group Registration Individual Fee -->
                                                        <div class="w-full">
                                                            <label class="mb-1 block text-sm font-medium text-black">Individual Fee</label>
                                                            <div class="relative">
                                                                <div class="absolute text-slate-400 font-bold inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                                    {{ $currency }}
                                                                </div>
                                                                <input 
                                                                    wire:model="groupRegIndividualFee"
                                                                    type="number" 
                                                                    step="0.10"
                                                                    min="0"
                                                                    placeholder="0.00" 
                                                                    class="placeholder:text-slate-300 focus:ring-0 bg-white w-full pl-6 rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                                                />
                                                            </div>
                                                            @error('groupRegIndividualFee')
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:w-1/2 w-full">
                                <label class="block text-sm font-medium text-black">Status<span class="text-red-500 px-1">*</span></label>
                                <select wire:model="status" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary">
                                    <option value="draft">Draft</option>
                                    <option value="pending">Pending</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center gap-4">
                                <button 
                                    wire:target="save"
                                    wire:loading.attr="disabled"
                                    type="submit" 
                                    class="disabled:cursor-not-allowed disabled:opacity-50 w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-green-700 hover:bg-green-600 duration-300">
                                    <span wire:loading.remove wire:target="save">
                                        Save & Setup more settings
                                    </span>
                                    <span wire:loading wire:target="save">
                                        Saving...
                                    </span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="resetForm" 
                                    class="bg-slate-500 hover:bg-slate-600 duration-300 text-white p-4 rounded-md"
                                >
                                    Reset
                                </button>
                                <button 
                                    type="button"
                                    @click="show = false" 
                                    class="bg-red-500 hover:bg-red-600 duration-300 text-white p-4 rounded-md"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
