<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default">
        @if($speakers->count() == 0)
            <div class="flex flex-col gap-2 justify-center items-center border-t border-stroke px-4 py-4.5">
                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 pt-8 pb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400 dark:text-slate-500 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <p class="text-slate-400 text-lg font-medium">No programme speakers found</p>
                    <p class="text-slate-300 text-base">Try adjusting your search or filter criteria</p>
                </div>
                @livewire('admin.programme.speaker.add-speaker', ['programmeId' => $programmeId], key('add-speaker-center'))
            </div>
        @else
            <div class="flex justify-between items-center border-t border-stroke px-4 py-4.5">
                <p class="text-base uppercase tracking-wider text-slate-500 font-medium">Programme Speakers</p>
                @livewire('admin.programme.speaker.add-speaker', ['programmeId' => $programmeId], key('add-speaker-inline'))
            </div>
            <div class="max-w-full md:overflow-x-visible overflow-x-auto">
                <table class="w-full table-auto">
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($speakers as $key => $speaker)
                            <tr class="hover:bg-slate-100/50 duration-300 flex items-center border-t border-stroke px-4 py-4.5">
                                <td class="md:w-1/3 w-full">
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
                                            <p class="duration-300 text-md font-medium text-black capitalize my-0">{{ $speaker->title .' '. $speaker->name }}</p>
                                            <p class="text-xs text-slate-500 italic my-0">{{ $speaker->profession ? $speaker->profession : 'No profession provided' }}</p>
                                        </div>
                                    </div>                                
                                </td>
                                <td class="md:w-1/6 w-full flex justify-start items-center">
                                    <p class="md:text-sm text-xs font-medium text-black capitalize bg-slate-200 rounded-full px-3 py-0.5 border border-slate-300">{{ $speaker->pivot ? $speaker->pivot->type : '' }}</p>
                                </td>
                                <td class="md:w-1/3 w-full">
                                    <div class="items-center block justify-start">
                                        <p class="text-sm capitalize font-bold text-slate-700">
                                            <span class="text-sm font-medium text-slate-500">TOPIC: </span>
                                            {{ $speaker->pivot ? $speaker->pivot->details : 'No details provided' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="md:w-1/3 w-1/2 text-nowrap">
                                    <div class="relative flex items-center gap-2 justify-end">                            
                                        <button 
                                            x-cloak
                                            x-data="{ showToolTip: false }"
                                            wire:click="callEditSpeakerModal({{ $speaker->id }}, {{ $programmeId }})" 
                                            @mouseover="showToolTip = true" 
                                            @mouseleave="showToolTip = false"
                                            type="button" 
                                            class="font-thin inline-flex items-center hover:scale-105 duration-300 justify-center rounded-md py-2 text-center text-white drop-shadow text-xs"
                                        >
                                            <svg 
                                                class="w-5 h-5 stroke-blue-500 hover:-translate-y-0.5 duration-300 hover:stroke-blue-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            <div 
                                                x-show="showToolTip" 
                                                x-transition 
                                                class="absolute top-6.5 left-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-20">
                                                Update
                                            </div>
                                        </button>

                                        <div 
                                            x-cloak
                                            x-data="{ showToolTip: false }" class="relative flex items-center gap-2">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @livewire('admin.programme.speaker.edit-speaker', key('edit-programme-speaker'))
</div>
