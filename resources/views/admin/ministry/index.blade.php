@section('title', 'Ministry Management')
<x-app-layout>
    <div class="flex justify-between gap-3 mb-3">
        <h4 class="text-2xl font-bold text-black dark:text-slate-600 capitalize">Ministry Management</h4>
        <a wire:navigate href="{{ route('admin.ministries.create') }}" 
            class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-3 px-5 mr-2">
            Create Ministry
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        @foreach ($ministries as $ministry)
            <div class="flex gap-3 border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
            {{-- <div class="flex gap-3 border border-slate-400/60 dark:border-slate-300/60 shadow-sm rounded-md p-4 bg-zinc-200 dark:bg-slate-700"> --}}
                <img src="https://placehold.co/400x400/gray/white" alt="{{ $ministry->name }}" class="w-16 h-16 rounded-full">
                <div>
                    <h4 class="text-xl font-bold text-slate-700 dark:text-slate-100 mb-3 capitalize">{{ $ministry->name }}</h4>
                    <div>
                        <table>
                            <tr>
                                <td class="text-sm py-1 text-slate-600 dark:text-white" width="100">Contact Person</td>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">: {{ $ministry->contactPerson ? $ministry->contactPerson : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">Contact Number</td>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">: {{ $ministry->contactNumber ? $ministry->contactNumber : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">Email</td>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">: {{ $ministry->contactEmail ? $ministry->contactEmail : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">Website</td>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">: {{ $ministry->website ? $ministry->website : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">Created By</td>
                                <td class="text-sm py-1 text-slate-600 dark:text-white">: {{ $ministry->requestedBy }}</td>
                            </tr>
                        </table>

                        <div class="mt-4 mb-2">
                            <button class="bg-slate-700 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-slate-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-600 px-4 py-2 rounded-full">
                                <a href="{{ route('admin.ministry.show', $ministry->id) }}">View Details</a>   
                            </button>
                            <button class="bg-slate-700 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-slate-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-600 px-4 py-2 rounded-full">
                                <a href="{{ route('admin.ministry.edit', $ministry->id) }}">Edit</a>   
                            </button>
                        </div>
                        
                        {{-- @dump($ministry) --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        {{-- <div class="lg:w-1/3 w-full">
            @dump($searchQuery)
        </div> --}}
</x-app-layout>
