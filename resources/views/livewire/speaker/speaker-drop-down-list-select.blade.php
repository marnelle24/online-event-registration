<div>
    <p class="text-md text-slate-600 mb-1">{{$label}}</p>
    <input 
        wire:model.live.debounce.300ms="search" 
        type="search" 
        class="focus:ring-0 focus:border-slate-600 min-h-12 text-lg w-full rounded-md bg-light border border-slate-500" 
        placeholder="Search Speakers"
    />
    
    @if($search)
        <ul class="relative z-10 shadow-lg bg-white max-h-[260px] overflow-y-auto">
            @foreach($speakers as $speaker)
                <li class="flex justify-between border-x border-b border-slate-400 py-2 px-4 hover:bg-slate-100 cursor-pointer">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if(is_null($speaker->thumbnail))
                                <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-12 h-12 drop-shadow tracking-widest">
                                    {{ Helper::getInitials($speaker->name) }}
                                </p>
                            @else
                                <img src="{{ asset($speaker->thumbnail) }}" alt="{{ $speaker->name }}" class="w-10 h-10 rounded-full" />
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-md font-medium text-black dark:text-white">{{ $speaker->name }}</p>
                            <p class="text-sm text-slate-500">{{ $speaker->profession }}</p>
                        </div>
                    </div>
                    <button  type="button" wire:click.prevent="selectSpeaker({{ $speaker->id }})" class="text-sm text-blue-400 hover:text-blue-800 hover:-translate-y-1 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>
