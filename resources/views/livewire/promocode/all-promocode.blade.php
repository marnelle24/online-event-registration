<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="w-full flex justify-between items-center border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="text-md text-slate-500 uppercase tracking-wider font-thin">
                Promocodes
            </p>
            @livewire('promocode.add-promocode', ['programmeId' => $programmeId], key('add-promocode'))
        </div>
        <div>
            @if($promocodes->isEmpty())
                <div class="flex flex-col justify-center items-center h-full">
                    <p class="text-md text-slate-500 uppercase tracking-wider font-thin py-12">
                        No Promocodes
                    </p>
                </div>
            @else
                @foreach ($promocodes as $key => $promocode)
                    <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-10 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                        <div class="col-span-3 flex items-center">
                            <div class="flex flex-col">
                                <p class="capitalize tracking-widest duration-300 text-md font-medium text-black dark:text-white">{{ $promocode->promocode }}</p>
                                <p class="text-xs text-slate-500 font-mono">
                                    {{ \Carbon\Carbon::parse($promocode->startDate)->format('M j') }} - {{ \Carbon\Carbon::parse($promocode->endDate)->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center justify-center">
                            <p class="text-sm font-medium text-black dark:text-white capitalize">
                                {{ 'SGD '.number_format($promocode->price, 2) }}
                            </p>
                        </div>
                        <div class="col-span-1 flex items-center justify-center">
                            <p class="flex items-center text-sm font-medium text-black dark:text-white capitalize">
                                @if($promocode->maxUses > 0)
                                    <span>{{ $promocode->usedCount .' / '. $promocode->maxUses }}</span>
                                @else
                                    <span>{{ $promocode->usedCount }} /</span>
                                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" class="w-6 h-6">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier"> 
                                            <path d="M20.288 9.463a4.856 4.856 0 0 0-4.336-2.3 4.586 4.586 0 0 0-3.343 1.767c.071.116.148.226.212.347l.879 1.652.134-.254a2.71 2.71 0 0 1 2.206-1.519 2.845 2.845 0 1 1 0 5.686 2.708 2.708 0 0 1-2.205-1.518L13.131 12l-1.193-2.26a4.709 4.709 0 0 0-3.89-2.581 4.845 4.845 0 1 0 0 9.682 4.586 4.586 0 0 0 3.343-1.767c-.071-.116-.148-.226-.212-.347l-.879-1.656-.134.254a2.71 2.71 0 0 1-2.206 1.519 2.855 2.855 0 0 1-2.559-1.369 2.825 2.825 0 0 1 0-2.946 2.862 2.862 0 0 1 2.442-1.374h.121a2.708 2.708 0 0 1 2.205 1.518l.7 1.327 1.193 2.26a4.709 4.709 0 0 0 3.89 2.581h.209a4.846 4.846 0 0 0 4.127-7.378z"></path> 
                                        </g>
                                    </svg>
                                @endif
                            </p>
                        </div>
                        <div class="col-span-2 flex items-center justify-center">
                            @if($promocode->isActive)
                                <p class="inline-flex border border-success rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Active</p>
                            @else
                                <p class="inline-flex border border-danger rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Inactive</p>
                            @endif
                        </div>
                        <div class="col-span-1 flex justify-end items-center gap-3">
                            @livewire('promocode.edit-promocode', ['promocode' => $promocode], key($key))
                            <button 
                                wire:click="removePromocode({{ $promocode->id }})"
                                wire:confirm="Are you sure you want to delete this promocode?"
                                type="button" 
                                title="Delete Promocode" 
                                class="transform hover:scale-110 transition-all duration-300"
                                x-data="{ showToolTip: false }"
                                @mouseover="showToolTip = true" 
                                @mouseleave="showToolTip = false"
                            >
                                <svg class="w-5 h-5 stroke-red-400 hover:stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                <div x-show="showToolTip" x-transition class="absolute top-4 left-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-20">
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
