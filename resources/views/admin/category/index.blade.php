@section('title', 'Category Management')
<x-app-layout>
    <h4 class="text-2xl font-bold text-black dark:text-slate-600 mb-8 capitalize">Category Management</h4>
    <div class="flex lg:flex-row md:flex-row sm:flex-col flex-col gap-4">
        <div class="w-2/3">
            <livewire:category.category-list />
        </div>
        <div class="w-1/3">
            <livewire:category.category-form />
        </div>
    </div>
</x-app-layout>
