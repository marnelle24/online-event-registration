<div class="relative">
    @if($show)
    <div 
        x-data="{ show: @entangle('show') }"
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
            class="absolute right-0 top-0 h-full w-full max-w-lg bg-white shadow-xl"
        >
                
            <div class="flex h-full flex-col">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Update Speaker</h2>
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
                    <form wire:submit.prevent="save" class="flex flex-col gap-4 h-screen">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Update the speaker details. 
                                Newly updated speaker will immediately reflected to the programme
                            </p>
                        </div>
                        <div class="space-y-4 flex flex-col gap-4">
                        
                            <div class="flex flex-col gap-4">
                                <div>
                                    <p class="text-sm mb-1">
                                        Find the existing speaker or professional
                                        <span class="text-red-500">*</span>
                                    </p>
                                    <select wire:model="speakerID" class="focus:ring-0 focus:border-slate-600 min-h-12 w-full rounded-none bg-white border border-slate-400">
                                        <option value="" {{ $speakerID == '' ? 'selected' : '' }}>Select Speaker</option>
                                        @foreach($speakers as $speaker)
                                            <option value="{{$speaker->id}}" class="capitalize" {{ $speakerID == $speaker->id ? 'selected' : '' }}>
                                                {{$speaker->name}} - {{ $speaker->profession}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <p class="text-sm mb-1">
                                        What's the function of the speaker in the programme?
                                        <span class="text-red-500">*</span>
                                    </p>
                                    <select wire:model="type" class="focus:ring-0 focus:border-slate-600 min-h-12 w-full rounded-none bg-white border border-slate-400">
                                        <option value="" {{ $type == '' ? 'selected' : '' }}>Update as</option>
                                        <option value="speaker" {{ $type == 'speaker' ? 'selected' : '' }}>Speaker</option>
                                        <option value="trainer" {{ $type == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                        <option value="facilitator" {{ $type == 'facilitator' ? 'selected' : '' }}>Facilitator</option>
                                        <option value="others" {{ $type == 'others' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <p class="text-sm mb-1">
                                        What's the topic or short details of the role?
                                        <span class="text-red-500">*</span>
                                    </p>
                                    <textarea 
                                        wire:model="details"
                                        rows="4" 
                                        class="focus:ring-0 focus:border-slate-600 min-h-12 w-full rounded-none bg-white border border-slate-400" placeholder="Topic or short details of the role"></textarea>
                                </div>
                            </div>

                            <div class="flex justify-between items-center gap-4">
                                <button 
                                    wire:target="save"
                                    wire:loading.attr="disabled"
                                    type="submit" 
                                    class="disabled:cursor-not-allowed disabled:opacity-50 w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-green-700 hover:bg-green-600 duration-300">
                                    <span wire:loading.remove wire:target="save">
                                        Save
                                    </span>
                                    <span wire:loading wire:target="save">
                                        Saving...
                                    </span>

                                </button>
                                <button 
                                    type="button"
                                    wire:click="resetForm" 
                                    class="bg-slate-500 hover:bg-slate-600 duration-300 text-white p-4 rounded-md">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>