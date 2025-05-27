<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        @if($speakers->count() == 0)
            <div class="flex flex-col gap-4 justify-center items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <p class="text-center italic text-slate-500">
                    No Speakers Found
                </p>
                <button type="button" class="inline-flex items-center hover:bg-slate-200 duration-300 justify-center rounded-md border border-black px-5 py-2 text-center font-medium text-black hover:bg-opacity-90 lg:px-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Speaker
                </button>
            </div>
        @else
            <div class="px-4 py-6 md:px-6 xl:px-7.5 flex">
                <input type="search" 
                    wire:model.live.debounce.300ms="search" 
                    class="focus:ring-0 lg:w-1/4 w-full rounded-md bg-light border border-slate-300 rounded-r-none" 
                    placeholder="Search by name or email" 
                />
                <button type="button" class="inline-flex items-center bg-slate-300 hover:bg-slate-400 duration-300 rounded-l-none justify-center rounded-md border py-2 text-center border-slate-400 font-medium text-slate-600 text-sm border-l-none hover:bg-opacity-90 lg:px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Speaker
                </button>
            </div>
            <div class="grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <div class="col-span-3 flex items-center">
                    <p class="font-medium">Name</p>
                </div>
                <div class="col-span-2 hidden items-center sm:flex">
                    <p class="font-medium">Email</p>
                </div>
                <div class="col-span-1 flex items-center">
                    <p class="font-medium">Socials</p>
                </div>
                <div class="col-span-1 flex items-center">
                    <p class="font-medium">&nbsp;</p>
                </div>
            </div>
            @foreach ($speakers as $speaker)
                <div class="grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                    <div class="col-span-3 flex items-center">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <div class="rounded-md">
                                @if(is_null($speaker->thumbnail))
                                    <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                        {{ Helper::getInitials($speaker->name) }}
                                    </p>
                                @else
                                    <img src="{{asset($speaker->thumbnail)}}" alt="Product" />
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <p class="text-md font-medium text-black dark:text-white">{{ ($speaker->title ? $speaker->title.'. ' : '') . $speaker->name }}</p>
                                <p class="text-sm text-slate-500">{{ $speaker->profession }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-span-2 hidden items-center sm:flex">
                        <p class="text-sm font-medium text-black dark:text-white">{{ $speaker->email }}</p>
                    </div>
                    <div class="col-span-2 flex items-center">
                        <div class="text-sm flex lg:flex-row flex-col gap-1 font-medium text-black dark:text-white">
                            @if($speaker->socials)
                                @foreach ($speaker->socials as $value)
                                    <a href="{{ $value['url'] }}" target="_blank" class="text-center text-slate-500 hover:text-meta-3 text-xs py-0.5 px-2 border border-slate-500 hover:border-meta-3 rounded-full mr-1">
                                        {{ $value['name'] }}
                                    </a>
                                @endforeach
                            @else
                                <p class="text-sm font-medium text-slate-500">No Socials</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center justify-end">
                        @if($speaker->is_active)
                            <span class="uppercase inline-flex items-center justify-end py-1 px-3 text-[10px] drop-shadow text-white rounded-full bg-green-500">Active</span>
                        @else
                            <span class="uppercase inline-flex items-center justify-end py-1 px-3 text-[10px] drop-shadow text-white rounded-full bg-green-500">Inactive</span>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
