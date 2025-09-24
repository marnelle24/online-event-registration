<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        @if($speakers->count() == 0)
            <div class="flex flex-col gap-4 justify-center items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <p class="text-center uppercase tracking-widest text-slate-400">
                    No Speakers Found
                </p>
                @livewire('programme.speaker.add-speaker', ['programmeId' => $programmeId], key('add-speaker-center'))
            </div>
        @else
            <div class="flex justify-between items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <p class="text-md text-slate-500 uppercase font-light tracking-widest">
                    Speakers
                </p>
                @livewire('programme.speaker.add-speaker', ['programmeId' => $programmeId], key('add-speaker-inline'))
            </div>
            @foreach ($speakers as $key => $speaker)
                <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                    <div class="col-span-3 flex items-center">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <div class="rounded-md">
                                @if(!$speaker->hasMedia('speaker'))
                                    <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                        {{ Helper::getInitials($speaker->name) }}
                                    </p>
                                @else
                                    <img src="{{ $speaker->getFirstMediaUrl('speaker') }}" alt="speaker" class="flex justify-center items-center rounded-full border w-10 h-10" />
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <p class="duration-300 text-md font-medium text-black capitalize">{{ $speaker->title .' '. $speaker->name }}</p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-span-3 items-center block justify-start">
                        <p class="text-xs font-medium text-slate-500 italic">TOPIC: </p>
                        <p class="text-sm capitalize font-bold text-slate-700">{{ $speaker->pivot ? $speaker->pivot->details : 'No details provided' }}</p>
                    </div>
                    <div class="col-span-1 items-center flex justify-start">
                        <p class="text-sm font-medium text-black capitalize bg-slate-200 rounded-full px-3 py-0.5 border border-slate-300">{{ $speaker->pivot ? $speaker->pivot->type : '' }}</p>
                    </div>
                    <div class="col-span-1 flex items-center gap-2 justify-end">
                        <div class="relative flex items-center gap-2 justify-end">

                            @livewire('programme.speaker.edit-speaker', ['speaker' => $speaker, 'programmeId' => $programmeId], key('edit-speaker-'.$speaker->id))
                            
                            <div x-data="{ showToolTip: false }" class="relative flex items-center gap-2">
                                <button 
                                    wire:click="removeSpeaker({{ $speaker->id }})"
                                    wire:confirm="Are you sure you want to remove this speaker from this programme?"
                                    type="button" 
                                    title="Remove Speaker" 
                                    class="transform hover:scale-110 transition-all duration-300"
                                    x-data="{ showToolTip: false }"
                                    @mouseover="showToolTip = true" 
                                    @mouseleave="showToolTip = false"
                                >
                                    <svg class="w-5 h-5 stroke-red-400 hover:stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    <div x-show="showToolTip" x-transition class="absolute top-4 left-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-20">
                                        Remove
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
