<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex justify-between items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="text-md text-slate-500 uppercase tracking-wider font-thin">
                {{ $promocodes->count() > 0 ? 'Active Promo Codes' : 'No Active Promo Codes' }}
            </p>
            @livewire('promocode.promocode-slide-form', ['programmeId' => $programmeId])
        </div>
        @foreach ($promocodes as $key => $promocode)
            <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <div class="col-span-3 flex items-center">
                    <a href="#" class="group flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="flex flex-col">
                            <p class="group-hover:text-green-600 duration-300 text-md font-mono uppercase font-medium text-black dark:text-white">{{ $promocode->promocode }}</p>
                            <p class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($promocode->startDate)->format('M j') }} - {{ \Carbon\Carbon::parse($promocode->endDate)->format('M j, Y') }}
                            </p>
                        </div>
                    </a>

                </div>
                <div class="col-span-1 hidden items-center sm:flex">
                    <p class="text-sm font-medium text-black dark:text-white capitalize">
                        {{ 'SGD '.number_format($promocode->price, 2) }}
                    </p>
                </div>
                <div class="col-span-1 hidden items-center sm:flex">
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
                <div class="col-span-2 hidden items-center sm:flex">
                    @if($promocode->isActive)
                        <p class="inline-flex border border-success rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Active</p>
                    @else
                        <p class="inline-flex border border-danger rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Inactive</p>
                    @endif
                </div>
                <div class="col-span-1 flex items-center gap-2 justify-end">
                    <svg 
                        wire:click="removePromocode({{$promocode->id}})" 
                        wire:confirm="Are you sure you want to remove this speaker to this programme?"
                        class="stroke-red-400 hover:stroke-red-600 w-6 h-6 cursor-pointer hover:-translate-y-1 duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    @livewire('promocode.edit-promocode-slide-form', ['promocode' => $promocode], key($key))
                </div>
            </div>
        @endforeach
    </div>
</div>
