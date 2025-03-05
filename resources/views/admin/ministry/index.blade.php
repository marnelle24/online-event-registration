@section('title', 'Ministry Management')
<x-app-layout>
    <h4 class="text-2xl font-bold text-black dark:text-white mb-8 capitalize">Ministry Management</h4>
    <div class="flex lg:flex-row md:flex-row sm:flex-col flex-col gap-4">
        <div class="w-full">
            @dump($ministries)
        </div>
    </div>
</x-app-layout>
