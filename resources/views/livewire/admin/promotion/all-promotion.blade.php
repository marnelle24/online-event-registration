<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="w-full flex justify-between md:items-center items-start border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div>
                <p class="text-md text-slate-600 uppercase tracking-wider font-medium">Programme Promotions</p>
                <p class="text-sm text-slate-500">Manage promotions for your programme. (e.g. Early Bird, Chinese New Year, etc.)</p>
            </div>
            @livewire('admin.promotion.add-promotion', ['programmeId' => $programmeId], key('add-new-promotion'))
        </div>
        <div>
            @if($promotions->isEmpty())
                <div class="flex flex-col justify-center items-center h-full">
                    <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16 text-slate-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>

                        <p class="text-slate-400 text-lg font-medium">No promotions found</p>
                    </div>
                </div>
            @else
                @foreach ($promotions as $key => $promotion)
                    <div class="flex flex-col md:flex-row md:justify-start justify-center hover:bg-slate-100/50 duration-300 border-t border-stroke px-4 py-4.5 md:px-6 2xl:px-7.5">
                        <div class="md:w-1/2 w-full flex md:flex-row flex-col md:justify-start justify-center items-center gap-4">
                            <div class="rounded-md">
                                <p class="md:text-lg text-xl flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 md:w-10 md:h-10 w-16 h-16 drop-shadow tracking-widest">
                                    {{ Helper::getInitials($promotion->title) }}
                                </p>
                            </div>
                            <div class="flex flex-col md:items-start items-center text-center">
                                <p class="capitalize duration-300 lg:text-md text-xl font-medium text-slate-600">{{ $promotion->title }} </p>
                                <p class="text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($promotion->startDate)->format('M j') }} - {{ \Carbon\Carbon::parse($promotion->endDate)->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="md:w-1/6 w-full items-center sm:flex">
                            <p class="text-lg font-bold text-black capitalize md:text-left text-center">
                                {{ '$ '.number_format($promotion->price, 2) }}
                            </p>
                        </div>
                        <div class="text-sm md:w-1/3 w-full flex md:justify-start justify-center items-center text-slate-600/60 italic">
                            {{ $promotion->counter . ' registered' }}
                        </div>
                        <div class="md:w-1/3 w-full flex md:justify-start justify-center items-center md:mt-0 mt-5">
                            @if($promotion->isActive)
                                <p class="inline-flex border border-success rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Active</p>
                            @else
                                <p class="inline-flex border border-danger rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Inactive</p>
                            @endif
                        </div>
                        <div class="md:w-1/6 w-full md:flex hidden md:justify-end justify-center items-center gap-3 md:mt-0 mt-5">
                            <button 
                                wire:click="callEditPromotionModal({{ $promotion->id }})"
                                x-cloak
                                x-data="{ showToolTip: false }"
                                @mouseover="showToolTip = true" 
                                @mouseleave="showToolTip = false"
                                type="button" 
                                class="relative font-thin inline-flex items-center hover:scale-105 duration-300 justify-center rounded-md py-2 text-center text-white drop-shadow text-xs"
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
                                wire:click="deletePromotion({{ $promotion->id }})"
                                wire:confirm="Are you sure you want to delete this promotion?"
                                type="button" 
                                title="Delete Promotion" 
                                class="transform hover:scale-110 transition-all duration-300"
                                x-cloak
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
                        <div class="md:w-1/6 w-full flex md:justify-end justify-center items-center gap-3 md:mt-0 mt-5 md:hidden">
                            <p class="flex items-center gap-2">
                                <span wire:click="callEditPromotionModal({{ $promotion->id }})" class="text-sm text-blue-400 cursor-pointer hover:text-blue-600 duration-300">Edit</span>
                                <span class="text-sm text-slate-500">|</span>
                                <span wire:click="deletePromotion({{ $promotion->id }})" wire:confirm="Are you sure you want to delete this promotion?" class="text-sm text-red-400 cursor-pointer hover:text-red-600 duration-300">Remove</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @livewire('admin.promotion.edit-promotion', key('edit-programme-promotion'))
</div>
