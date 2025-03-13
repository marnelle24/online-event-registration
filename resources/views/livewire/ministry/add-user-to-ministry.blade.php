<div class="flex flex-col pb-5 border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md">
    <h4 class="text-2xl font-bold text-slate-700 dark:text-white capitalize rounded-t-lg p-4 bg-slate-100 dark:bg-slate-600 border-b border-slate-400/20">Ministry User</h4>
    <div class="p-6">
        <p class="text-sm text-slate-700 dark:text-white mb-4">
            Add a user to the ministry by searching for their name and clicking the "Add" button.
        </p>
        <div class="flex flex-col relative">
            <input 
                wire:model.live.debounce.1000ms="search"
                placeholder="Search for a user"
                type="search" 
                class="w-full rounded-none bg-zinc-50 py-4 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input"
            />
            @if(!empty($search))
                <div class="border border-slate-400/20 rounded-b-lg shadow-md absolute z-20 top-12 left-0 w-full bg-white dark:bg-slate-600">
                    <ul class="list-none list-inside">
                        @if($users->isEmpty())
                            <li class="p-4">
                                <div class="flex justify-between items-center gap-2">
                                    <span class="text-slate-700 dark:text-white">No users found</span>
                                </div>
                            </li>
                        @else
                            @foreach ($users as $user)
                            <li class="p-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-300">
                                <div class="flex justify-between items-center gap-2">
                                    <span class="text-slate-700 dark:text-white">{{ $user->name }}</span>
                                    <svg wire:click="addUserToMinistry({{$user->id}})" wire:confirm="Are you sure to add this user?" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-green-600 font-extrabold cursor-pointer hover:-translate-y-1 transition-all duration-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        <p class="text-md text-slate-700 dark:text-white mt-6 font-medium underline">
            Ministry Users
        </p>
        @if($ministry->users->count() > 0)
            <ul class="list-none list-inside mt-2">
                @foreach ($ministry->users as $user)
                    <li class="my-2 flex justify-between items-center gap-2 bg-zinc-100 dark:bg-slate-800 border border-slate-400/50 px-4 py-2 rounded-md hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-slate-900 dark:stroke-slate-100">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span class="text-slate-700 dark:text-white">
                                {{ $user->name }}
                            </span>
                        </div>
                        <svg wire:click="detachUserToMinistry({{$user->id}})" wire:confirm="Are you sure you want to remove this user?" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-red-500 dark:stroke-red-300 cursor-pointer hover:-translate-y-1 transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-md text-slate-700 dark:text-white mt-2">
                No users assigned to this ministry yet.
            </p>
        @endif
    </div>

    {{-- @dump($ministry) --}}
</div>