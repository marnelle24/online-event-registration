<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="w-full flex justify-between items-center border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="text-md text-slate-500 uppercase tracking-wider font-thin">
                Promotions
            </p>
            @livewire('promotion.add-promotion', ['programmeId' => $programmeId], key('add-new-promotion'))
        </div>
        <div>
            @if($promotions->isEmpty())
                <div class="flex flex-col justify-center items-center h-full">
                    <p class="text-md text-slate-500 uppercase tracking-wider font-thin py-12">
                        No Promotions
                    </p>
                </div>
            @else
                @foreach ($promotions as $key => $promotion)
                    <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-10 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                        <div class="col-span-3 flex items-center gap-4">
                            <div class="rounded-md">
                                <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                    {{ Helper::getInitials($promotion->title) }}
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <p class="capitalize duration-300 text-md font-medium text-black dark:text-white">{{ $promotion->title }}</p>
                                <p class="text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($promotion->startDate)->format('M j') }} - {{ \Carbon\Carbon::parse($promotion->endDate)->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-1 hidden items-center sm:flex">
                            <p class="text-sm font-medium text-black dark:text-white capitalize">
                                {{ 'SGD '.number_format($promotion->price, 2) }}
                            </p>
                        </div>
                        <div class="col-span-2 hidden items-center sm:flex text-slate-600/60 justify-center italic">
                            {{ $promotion->counter . ' registered' }}
                        </div>
                        <div class="col-span-1 hidden items-center sm:flex">
                            @if($promotion->isActive)
                                <p class="inline-flex border border-success rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Active</p>
                            @else
                                <p class="inline-flex border border-danger rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Inactive</p>
                            @endif
                        </div>
                        <div class="col-span-1 flex justify-end items-center gap-3">
                            @livewire('promotion.edit-promotion', ['promotion' => $promotion], key($key))
                            <button 
                                wire:click="deletePromotion({{ $promotion->id }})"
                                wire:confirm="Are you sure you want to delete this promotion?"
                                type="button" 
                                title="Delete Promotion" 
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
