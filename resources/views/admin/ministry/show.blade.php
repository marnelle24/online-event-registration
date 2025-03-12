@section('title', 'Ministry Management')
<x-app-layout>
    <h4 class="text-2xl font-bold text-black dark:text-slate-600 mb-8 capitalize">
        {{ $ministry->name }}
    </h4>
    <div class="flex lg:flex-row md:flex-row sm:flex-col flex-col gap-4">
        <div class="lg:w-full w-full flex flex-col gap-2">
           @dump($ministry)
        </div>
        {{-- <div class="lg:w-1/3 w-full">
            @dump($searchQuery)
        </div> --}}
    </div>
</x-app-layout>
