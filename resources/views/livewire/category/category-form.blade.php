<div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md">
    <h4 class="text-2xl font-bold text-slate-700 dark:text-white capitalize rounded-t-lg p-4 bg-slate-100 dark:bg-slate-600 border-b border-slate-400/20">
        {{ $isEditing ? 'Edit Category' : 'Create New Category' }}
    </h4>

    <form wire:submit="save" class="p-6">
    {{-- <form wire:submit="{{ $isEditing ? 'update' : 'create' }}"> --}}
        <div class="mb-4">
            <label for="name" class="mb-2.5 block font-medium text-black dark:text-white">Name</label>
            <div class="relative">
                <input wire:model="name" type="text" placeholder="Enter category name"
                    class="w-full rounded-none bg-transparent py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input" />
            </div>
            @error('name')
                <p class="mt-1 text-xs text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="slug" class="mb-2.5 block font-medium text-black dark:text-white">Slug <em>(Optional)</em></label>
            <div class="relative">
                <input wire:model="slug" type="text" placeholder="Slug"
                    class="w-full rounded-none bg-transparent py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input" />
            </div>
            @error('slug')
                <p class="mt-1 text-xs text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                    class="flex items-center justify-center rounded-full bg-slate-600 dark:bg-slate-500 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-slate-700 dark:hover:bg-slate-400 hover:-translate-y-1 duration-300 py-2 px-6 font-medium text-white">
                    {{ $isEditing ? 'Update' : 'Save' }}
                </button>
                <span wire:loading.delay.longest class="ml-2">
                    saving...
                </span>
            </div>

            @if($isEditing)
                <button type="button" wire:click="cancelEdit"
                    class="flex items-center justify-center text-red-400 font-medium border border-red-400 hover:bg-red-400/70 hover:text-white hover:-translate-y-1 duration-300 rounded-full py-2 px-6">
                    Cancel
                </button>
            @endif
        </div>
    </form>
</div>