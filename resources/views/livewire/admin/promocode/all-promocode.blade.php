<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="w-full flex justify-between md:items-center items-start border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div>
                <p class="text-md text-slate-600 uppercase tracking-wider font-medium">Programme Promocodes</p>
                <p class="text-sm text-slate-500">Manage promocodes for your programme. (e.g. DISCOUNT10, DISCOUNT20, etc.)</p>
            </div>

            @livewire('admin.promocode.add-promocode', ['programmeId' => $programmeId], key('add-promocode'))
        </div>
        <div>
            @if($promocodes->isEmpty())
                <div class="flex flex-col justify-center items-center h-full">
                    <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16 text-slate-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>

                        <p class="text-slate-400 text-lg font-medium">No promocodes found</p>
                    </div>
                </div>
            @else
                @foreach ($promocodes as $key => $promocode)
                    <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-1 border-t border-stroke px-4 py-4.5 md:grid-cols-6 md:px-6 2xl:px-7.5">
                        <div class="col-span-2 flex md:justify-start justify-center items-center">
                            <div class="flex flex-col md:gap-0 gap-1">
                                <p class="capitalize tracking-widest duration-300 md:text-md text-lg font-bold text-slate-600 bg-slate-100 text-center rounded-none border border-slate-300 px-2 py-1">{{ $promocode->promocode }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ \Carbon\Carbon::parse($promocode->startDate)->format('M j') }} - {{ \Carbon\Carbon::parse($promocode->endDate)->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="md:col-span-1 col-span-2 flex items-center justify-center md:my-0 my-2">
                            <p class="md:text-sm text-lg font-bold text-slate-700 md:text-left text-center capitalize">
                                {{ '$'.number_format($promocode->price, 2) }}
                            </p>
                        </div>
                        <div class="md:col-span-1 col-span-2 flex items-center justify-center">
                            <p class="flex items-center text-sm font-medium text-black capitalize">
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
                        <div class="md:col-span-1 col-span-2 flex items-center justify-center md:mt-0 mt-2">
                            @if($promocode->isActive)
                                <p class="inline-flex border border-success rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Active</p>
                            @else
                                <p class="inline-flex border border-danger rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Inactive</p>
                            @endif
                        </div>
                        <div class="md:col-span-1 col-span-2 justify-end items-center gap-3 md:flex hidden">
                            <button 
                                x-cloak
                                x-data="{ showToolTip: false }"
                                wire:click="callEditPromocodeModal({{ $promocode->id }})" 
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
                            <button 
                                x-cloak
                                x-data="{ showToolTip: false }"
                                wire:click="removePromocode({{ $promocode->id }})"
                                wire:confirm="Are you sure you want to delete this promocode?"
                                type="button" 
                                title="Delete Promocode" 
                                class="transform hover:scale-110 transition-all duration-300"
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
                        <div class="md:w-1/6 w-full flex md:justify-end justify-center items-center gap-3 md:mt-0 mt-5 md:hidden">
                            <p class="flex items-center gap-2">
                                <span wire:click="callEditPromocodeModal({{ $promocode->id }})" class="text-sm text-blue-400 cursor-pointer hover:text-blue-600 duration-300">Edit</span>
                                <span class="text-sm text-slate-500">|</span>
                                <span wire:click="removePromocode({{ $promocode->id }})" wire:confirm="Are you sure you want to delete this promotion?" class="text-sm text-red-400 cursor-pointer hover:text-red-600 duration-300">Remove</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @livewire('admin.promocode.edit-promocode', key('edit-programme-promocode'))
</div>
