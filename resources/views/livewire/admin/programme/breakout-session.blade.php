<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex justify-between items-center border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="text-md text-slate-500 uppercase tracking-wider font-thin">
                Breakout Sessions
            </p>
            @livewire('admin.programme.breakout-session-slide-form', ['programmeId' => $programmeId])
        </div>
        <div>
            @if($breakouts->isEmpty())
                <div class="flex flex-col justify-center items-center h-full">
                    <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                        <svg class="size-16 text-slate-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                        </svg>
                        <p class="text-slate-400 text-lg font-medium">No breakout sessions found</p>
                    </div>
                </div>
            @else
                @foreach ($breakouts as $key => $breakout)
                    <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-10 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                        <div class="col-span-2 flex items-center">
                            <div class="flex gap-2">
                                <p class="text-[12px] flex justify-center items-center font-normal rounded-md text-slate-400 bg-slate-200 border border-slate-400 w-8 h-8 drop-shadow tracking-widest">
                                    {{ Helper::getInitials($breakout->speaker->name) }}
                                </p>
                                <div class="flex flex-col">
                                    <p class="text-lg capitalize text-slate-600 tracking-tight font-thin leading-tight">
                                        {{ $breakout->speaker->name }}
                                    </p>
                                    <p class="text-xs italic capitalize text-slate-400 font-thin tracking-wide leading-tight">
                                        Speaker
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-1">
                            <p class="text-xs italic capitalize text-slate-400 font-thin tracking-wide leading-0">
                                {{ 'Session '.($key + 1) }}
                            </p>
                            <p class="text-lg capitalize text-slate-600 tracking-wide font-bold leading-0">
                                {{ Str::words($breakout->title, 6) }}
                            </p>
                            {{-- <p class="text-xs italic capitalize text-slate-400 leading-tight font-thin tracking-wide">
                                {{ Str::words($breakout->description. 'fsdfsd fdsf  erg egr h t4rttyr yrt rt reyey r', 12, '...') }}
                            </p> --}}
                        </div>
                        <div class="col-span-2 flex flex-col space-y-2">
                            <div class="flex gap-1">
                                <p class="text-sm italic capitalize text-slate-600">
                                    Start:
                                </p>
                                <p class="text-sm capitalize text-slate-600">
                                    {{ \Carbon\Carbon::parse($breakout->startDate)->format('M j, Y @ h:i A') }}
                                </p>
                            </div>
                            <div class="flex gap-1">
                                <p class="text-sm italic capitalize text-slate-600">
                                    End:
                                </p>
                                <p class="text-sm capitalize text-slate-600">
                                    {{ \Carbon\Carbon::parse($breakout->endDate)->format('M j, Y @ h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-1 flex justify-center items-center">
                            <p class="text-sm capitalize text-slate-600">
                                {{ 'SGD'.$breakout->price }}
                            </p>
                        </div>
                        <div class="col-span-1 flex justify-end items-center gap-3">
                            @livewire('admin.programme.edit-breakout-session-slide-form', ['breakout' => $breakout], key($key))
                            <button 
                                wire:click="deleteBreakout({{ $breakout->id }})"
                                wire:confirm="Are you sure you want to delete this breakout session?"
                                type="button" 
                                title="Delete Programme" 
                                class="transform hover:scale-110 transition-all duration-300"
                                x-data="{ showToolTip: false }"
                                @mouseover="showToolTip = true" 
                                @mouseleave="showToolTip = false"
                            >
                                <svg class="w-5 h-5 stroke-red-400 hover:stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                <div x-show="showToolTip" x-transition class="absolute top-4 left-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                    Delete
                                </div>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
