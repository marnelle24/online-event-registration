<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        @if($this->filteredSpeakers->count() == 0)
            <div class="flex flex-col gap-4 justify-center items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <p class="text-center italic text-slate-500">
                    No Speakers Found
                </p>
                @livewire('speaker.speaker-slide-form')
            </div>
        @else
            <div class="px-4 py-6 md:px-6 xl:px-7.5 flex justify-between">
                <input type="search" 
                    class="focus:ring-0 lg:w-1/4 w-full rounded-md bg-light border border-slate-300 rounded-r-none" 
                    placeholder="Search by name or email" 
                />
                @livewire('speaker.speaker-slide-form')
            </div>
            <div class="grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <div class="col-span-3 flex items-center">
                    <p class="font-medium">Name</p>
                </div>
                <div class="col-span-2 hidden items-center sm:flex">
                    <p class="font-medium">Role</p>
                </div>
                <div class="col-span-1 flex items-center">
                    <p class="font-medium">Socials</p>
                </div>
                <div class="col-span-1 flex items-center">
                    <p class="font-medium">&nbsp;</p>
                </div>
            </div>
            @foreach ($this->filteredSpeakers as $speaker)
                <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                    <div class="col-span-3 flex items-center">
                        <a href="#" class="group flex flex-col gap-4 sm:flex-row sm:items-center">
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
                                <p class="group-hover:text-green-600 duration-300 text-md font-medium text-black dark:text-white">{{ ($speaker->title ? $speaker->title.'. ' : '') . $speaker->name }}</p>
                                <p class="text-sm text-slate-500">{{ $speaker->profession }}</p>
                            </div>
                        </a>

                    </div>
                    <div class="col-span-2 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white capitalize">{{ $speaker->pivot->type }}</p>
                    </div>
                    <div class="col-span-2 flex items-center">
                        <div class="text-sm flex lg:flex-row flex-col gap-1 font-medium text-black dark:text-white">
                            @if(!is_null($speaker->socials))
                                @foreach (json_decode($speaker->socials) as $social)
                                    <a href="{{ $social->url }}" target="_blank" class="text-center text-slate-500 hover:text-meta-3 text-xs py-0.5 px-2 border border-slate-500 hover:border-meta-3 rounded-full mr-1">
                                        {{ $social->platform }}
                                    </a>
                                @endforeach
                            @else
                                <p class="text-sm font-medium text-slate-500">No Socials</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center gap-1 justify-end">
                        @if($speaker->is_active)
                            <span class="uppercase inline-flex items-center justify-end py-1 px-3 text-[10px] drop-shadow text-white rounded-full bg-green-500">Active</span>
                        @else
                            <span class="uppercase inline-flex items-center justify-end py-1 px-3 text-[10px] drop-shadow text-white rounded-full bg-green-500">Inactive</span>
                        @endif

                        <button 
                            wire:click="removeSpeaker({{$speaker->id}})" 
                            wire:confirm="Are you sure you want to remove this speaker to this programme?"
                            type="button" class="text-xs flex text-red-400 border border-red-300 hover:bg-red-200 bg-red-100 rounded-full justify-center items-center hover:-translate-y-1 duration-300 px-2 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-red-400 hover:stroke-red-600 w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg> 
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
