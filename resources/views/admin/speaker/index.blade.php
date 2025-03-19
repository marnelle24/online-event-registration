@section('title', 'Speaker Management')
<x-app-layout>
    <div class="flex justify-between items-center gap-3 mb-8">
        <h4 class="lg:text-2xl text-xl font-bold text-black dark:text-slate-600 capitalize">Professionals Management</h4>
        <a wire:navigate href="{{ route('admin.speakers.create') }}" 
            class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold lg:py-3 py-2 px-5 mr-2">
            Add New
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        @foreach ($speakers as $speaker)
            <div class="flex flex-col border border-slate-400/70 rounded-lg bg-zinc-100 dark:bg-slate-700 hover:bg-neutral-200/70 hover:-translate-y-0.5 dark:hover:bg-slate-800/90 duration-300 shadow-md h-full">
                <div class="flex gap-3 p-4 bg-zinc-200 border-b border-slate-400/70 dark:bg-slate-800 rounded-t-lg items-center">
                    <img src="{{ $speaker->thumbnail ? Storage::url($speaker->thumbnail) : 'https://placehold.co/400x400/lightgray/white' }}" 
                         alt="{{ $speaker->name }}" 
                         class="w-14 h-14 object-cover border border-zinc-800/40 rounded-full">
                    <div>
                        <h4 class="text-xl font-bold text-slate-700 dark:text-slate-100 capitalize">
                            {{ $speaker->title ?? '' }}
                            {{ $speaker->name }}
                        </h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300">{{ $speaker->profession ?? 'No profession listed' }}</p>
                    </div>
                </div>
                <div class="flex flex-col flex-grow p-6">
                    <div class="flex-grow">
                        <table class="mb-2">
                            <tr>
                                <td class="text-sm py-1.5 text-slate-600 dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </td>
                                <td class="text-sm py-1.5 text-slate-600 dark:text-white"> {{ $speaker->email ?? 'N/A' }}</td>
                            </tr>
                        </table>
                        <div>
                            <p class="text-xs text-slate-600 dark:text-white italic">About:</p>
                            <p class="text-sm text-slate-600 dark:text-white">
                                {{ $speaker->about ? Str::words($speaker->about, 15) : 'N/A' }}
                            </p>
                        </div>
                        @if ($speaker->socials)
                            <div class="mt-4">
                                <p class="text-xs text-slate-600 dark:text-white italic">Socials:</p>
                                @foreach ($speaker->socials as $social)
                                    <a href="{{ $social['url'] }}" target="_blank" class="text-xs border border-slate-400/70 bg-slate-300 rounded-full mr-1 py-0.5 px-2 text-slate-600">
                                        {{ $social['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 flex gap-1 pt-4">
                        <a href="{{ route('admin.speakers.show', $speaker->id) }}" 
                           class="bg-slate-700 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-slate-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-600 px-3 py-1 rounded-full">
                            View
                        </a>
                        <a href="{{ route('admin.speakers.edit', $speaker->id) }}" 
                           class="bg-slate-700 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-slate-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-600 px-3 py-1 rounded-full">
                            Edit
                        </a>
                        <form action="{{ route('admin.speakers.destroy', $speaker->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this speaker?')"
                                    class="bg-red-600 dark:bg-red-400 hover:-translate-y-0.5 hover:bg-red-500 dark:hover:bg-red-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-300 px-3 py-1 rounded-full">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-20">
        {{ $speakers->links() }}
    </div>
</x-app-layout> 