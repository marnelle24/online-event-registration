<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex justify-between items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="font-medium text-xl text-slate-500">
                {{ $promotions->count() > 0 ? 'Active Promotions' : 'No Active Promotions' }}
            </p>
            @livewire('promotion.promotion-slide-form', ['programmeId' => $programmeId])
        </div>
        @foreach ($promotions as $promotion)
            <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <div class="col-span-3 flex items-center">
                    <a href="#" class="group flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="rounded-md">
                            <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                {{ Helper::getInitials($promotion->title) }}
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <p class="group-hover:text-green-600 duration-300 text-md font-medium text-black dark:text-white">{{ $promotion->title }}</p>
                            <p class="text-sm text-slate-500">
                                {{ \Carbon\Carbon::parse($promotion->startDate)->format('M j') }} - {{ \Carbon\Carbon::parse($promotion->endDate)->format('M j, Y') }}
                            </p>
                        </div>
                    </a>

                </div>
                <div class="col-span-2 hidden items-center sm:flex">
                    <p class="text-sm font-medium text-black dark:text-white capitalize">
                        {{ 'SGD '.number_format($promotion->price, 2) }}
                    </p>
                </div>
                <div class="col-span-2 hidden items-center sm:flex">
                    @if($promotion->isActive)
                        <span class="uppercase inline-flex items-center justify-end py-1 px-3 text-[10px] drop-shadow text-white rounded-full bg-green-500">Active</span>
                    @else
                        <span class="uppercase inline-flex items-center justify-end py-1 px-3 text-[10px] drop-shadow text-white rounded-full bg-red-500">Inactive</span>
                    @endif
                </div>
                <div class="col-span-1 flex items-center gap-1 justify-end">
                    <svg 
                        wire:click="removePromotion({{$promotion->id}})" 
                        wire:confirm="Are you sure you want to remove this speaker to this programme?"
                        class="stroke-red-400 hover:stroke-red-600 w-6 h-6 cursor-pointer hover:-translate-y-1 duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>
</div>
