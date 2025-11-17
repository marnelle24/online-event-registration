<div class="rounded-sm border border-stroke bg-white shadow-default w-full overflow-x-scroll">
    <div class="relative rounded-sm border border-stroke bg-white p-8 shadow-default">
        <div class="flex items-center gap-3">
            <p class="text-sm text-slate-500 py-2 border-slate-400">Excepts</p>
            <div x-cloak x-data="{ showToolTip: false }" class="relative">
                <svg 
                    wire:click="toogleShowEdit"
                    @mouseover="showToolTip = true" 
                    @mouseleave="showToolTip = false"
                    class="w-4 h-4 hover:scale-110 duration-300 hover:stroke-blue-600 cursor-pointer @if($showEdit) stroke-blue-600 scale-110 @endif"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                {{-- add tooltip --}}
                <div x-show="showToolTip" x-transition class="absolute top-4 -right-5 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                    Edit
                </div>
            </div>
        </div>

        @if(!$showEdit)
            <textarea
                wire:model.live.debounce.500ms="excerpt"
                rows="3"
                disabled
                placeholder="Enter the excerpt for this programme"
                name="excerpt"
                class="disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-200 focus:ring-0 rounded-md bg-slate-100 border border-solid px-3 py-2 flex items-center w-full min-h-[100px] border-neutral-400/70 text-base font-normal text-surface">{{old('excerpt', 'This is the excerpt for this programme')}}
            </textarea>
        @else
            @php($excerptLength = strlen($excerpt ?? ''))
            @php($excerptClass = $excerptLength > 298 ? 'border-red-500 focus:border-red-500' : 'border-neutral-400/70 focus:border-neutral-400')
            <textarea
                wire:model.live.debounce.500ms="excerpt"
                rows="3"
                placeholder="Excerpt"
                name="excerpt"
                maxlength="300"
                class="{{$excerptClass}} w-full min-h-[100px] disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-200 focus:ring-0 rounded-md bg-slate-100 border border-solid border-neutral-400/70 focus:border-neutral-400 px-3 py-2 flex items-center text-base font-normal text-surface">{{old('excerpt', 'This is the excerpt for this programme')}}
            </textarea>
            <em class="text-slate-500 italic pt-2 text-sm flex justify-between">
                <span class="text-slate-500">
                    {{ $excerptLength }}/300 characters
                </span>
                {{-- add color to the text based on the length --}}
                @if($excerptLength > 298)
                    <span class="text-red-500">
                        You are approaching the limit
                    </span>
                @endif
            </em>
            <div class="flex gap-3 items-center justify-end">
                <svg 
                    wire:click="updateExcerpt" 
                    wire:confirm="Are you sure to make this changes?"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <svg
                    wire:click="toogleShowEdit"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110  duration-300 stroke-red-500 hover:stroke-red-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
        @endif
        <hr class="my-4 border-slate-400/70 border-dashed" />
        <div class="flex items-center gap-3">
            <p class="text-sm text-slate-500 py-2 border-slate-400">Description</p>
            <div x-cloak x-data="{ showToolTip: false }" class="relative">
                <svg 
                    wire:click="toogleShowEditDescription"
                    @mouseover="showToolTip = true" 
                    @mouseleave="showToolTip = false"
                    class="w-4 h-4 hover:scale-110 duration-300 hover:stroke-blue-600 cursor-pointer @if($showEditDescription) stroke-blue-600 scale-110 @endif"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <div x-show="showToolTip" x-transition class="absolute top-5 -right-5 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                    Edit
                </div>
            </div>
        </div>
        @if(!$showEditDescription)
             <textarea
                wire:model.live.debounce.500ms="description"
                rows="6"
                placeholder="Description"
                disabled
                name="description"
                class="ck-content w-full min-h-[100px] disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-200 focus:ring-0 rounded-md bg-slate-100 border border-solid px-3 py-2 flex items-center text-base font-normal text-surface">{{old('description', 'This is the description for this programme')}}
            </textarea>
        @else
            <textarea
                wire:model.live.debounce.500ms="description"
                rows="6"
                placeholder="Description"
                name="description"
                class="ck-content w-full min-h-[100px] disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-200 focus:ring-0 rounded-md bg-slate-100 border border-solid border-neutral-400/70 focus:border-neutral-400 px-3 py-2 flex items-center text-base font-normal text-surface">{{old('description', 'This is the description for this programme')}}
            </textarea>
            @if($showEditDescription)
                <div class="flex gap-3 items-center justify-end mt-2">
                    <svg 
                        wire:click="updateDescription" 
                        wire:confirm="Are you sure to make this changes?"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110 duration-300 stroke-success">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    <svg 
                        wire:click="toogleShowEditDescription"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:scale-110  duration-300 stroke-red-500 hover:stroke-red-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
            @endif
        @endif
        <hr class="my-4 border-slate-400/70 border-dashed" />

        <div class="mt-4 flex flex-col justify-between">
            <div class="flex items-center gap-1">
                <p class="text-sm italic text-slate-500 py-2 border-slate-400">Categories:</p>
                @livewire('admin.programme.update-category', ['programmeId' => $programme->id, 'programmeCategories' => $programme->categories], key('update-category'))
            </div>
            <div class="flex flex-wrap whitespace-normal gap-2">
                @livewire('admin.category.bubble-list', ['programmeId' => $programme->id, 'canRemove' => false], key('bubble-list'))
            </div>
        </div>
    </div>
</div>