<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex justify-between items-center border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="text-md text-slate-500 uppercase tracking-wider font-thin">
                Breakout Sessions
            </p>
            @livewire('programme.breakout-session-slide-form', ['programmeId' => $programmeId])
        </div>
        <div>
            @if($breakouts->isEmpty())
                <div class="flex flex-col justify-center items-center h-full">
                    <p class="text-md text-slate-500 uppercase tracking-wider font-thin py-12">
                        No Breakout Sessions
                    </p>
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
                            {{-- <form 
                                action="" 
                                method="POST" onsubmit="return confirm('Are you sure you want to delete this programme? This action cannot be undone.');">
                                @csrf
                                @method('PUT') --}}
                            @livewire('programme.edit-breakout-session-slide-form', ['breakout' => $breakout], key($key))
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
                                <div x-show="showToolTip" x-transition class="absolute top-full -left-1 mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                    Delete
                                </div>
                            </button>
                            {{-- </form> --}}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
