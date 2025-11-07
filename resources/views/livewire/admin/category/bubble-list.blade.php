<div>
    @foreach ($categories as $category)
        <p class="items-center justify-between gap-2 inline-flex my-1 rounded-full bg-warning hover:bg-warning/60 hover:text-white transition-all duration-300 bg-opacity-20 border border-warning px-3 py-1 text-sm font-medium text-warning">
            <span>{{$category->name}}</span>
            @if($canRemove)
                <svg 
                    wire:click="removeCategory({{$category->id}})" 
                    wire:confirm="Are you sure you want to remove this category?" 
                    class="w-4 h-4 cursor-pointer stroke-red-400 hover:stroke-white hover:scale-110 duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            @endif
        </p>
    @endforeach
</div>
