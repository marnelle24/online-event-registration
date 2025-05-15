    <div class="flex flex-col border border-slate-400/70 rounded-lg bg-zinc-100 dark:bg-slate-700 hover:bg-neutral-200/70 hover:-translate-y-0.5 dark:hover:bg-slate-800/90 duration-300 shadow-md h-full">
        <div 
            class="relative min-h-[250px] flex justify-center p-4 border-b border-slate-400/70 dark:bg-slate-800 rounded-t-lg items-center bg-zinc-200"
            style="background-position:center;object-fit:cover;background-image:linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ), url('{{ $programme->getFirstMediaUrl('thumbnail') }}');"
        >
            @if($programme->getFirstMediaUrl('thumbnail') === '')
                <p class="text-6xl font-normal rounded-full text-slate-400 drop-shadow text-center tracking-widest">
                    {{ Helper::getInitials($programme->title) }}
                </p>
            @endif

            <div class="absolute bottom-3 right-3 mt-8 flex gap-1 pt-4 z-30">
                <a href="{{ route('admin.programmes.show', $programme->programmeCode) }}" 
                    class="bg-orange-500 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-orange-400 dark:hover:bg-slate-300 transition-all duration-300 shadow text-sm text-white dark:text-slate-600 px-3 py-1 rounded-lgs">
                    View
                </a>
                <a href="{{ route('admin.programmes.edit', $programme->id) }}" 
                    class="bg-sky-600 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-sky-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-sm text-white dark:text-slate-600 px-3 py-1 rounded-lgs">
                    Edit
                </a>
            </div>
        </div>
        <div class="flex flex-col flex-grow p-6">
            <div class="flex-grow">
                <h4 class="text-xl font-bold text-slate-600 dark:text-slate-100 capitalize leading-0 mb-2">
                    {{ Str::words($programme->title, 6, '...') }}
                </h4>
                <div class="flex mb-3 items-center">
                    <p class="border border-zinc-400 bg-zinc-200 text-zinc-500 text-xs py-0.5 px-2 font-light flex place-content-center text-center uppercase rounded">{{ $programme->ministry->name}}</p>
                </div>
                <table class="my-2">
                    <tr>
                        <td class="text-sm text-slate-600 dark:text-white flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </td>
                        <td class="text-sm px-1 text-slate-600 dark:text-white capitalize overflow-ellipsis">
                            {{ $programmeLocation }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm text-slate-600 dark:text-white flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                        </td>
                        <td class="text-sm px-1 text-slate-600 dark:text-white {{$programme->customDate ? '' : 'uppercase'}}">
                            {{ $programmeDates }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm text-slate-600 dark:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </td>
                        <td class="text-sm px-1 text-slate-600 dark:text-white">
                            <p class="text-sm capitalize">
                                {{ $programmeTimes }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm text-slate-600 dark:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </td>
                        <td class="text-sm px-1 text-slate-600 dark:text-white">
                            <p class="text-sm uppercase">
                                {{ $programmePrice }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm text-slate-600 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        </td>
                        <td class="text-sm px-1 text-slate-600 dark:text-white">
                            <p class="text-sm">
                                100 / {{ $programme->limit > 0 ? $programme->limit : 'No limit' }}
                            </p>
                        </td>
                    </tr>
                </table>
                <div>
                    <p class="text-sm text-slate-600 dark:text-white">
                        {{ $programme->excerpt !== '' ? $programme->excerpt : Str::words($programme->description, 12, '...') }}
                    </p>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                @if($programme->categories->count() > 0)
                    @foreach ($programme->categories as $category)
                        <span class="border bg-zinc-200 text-zinc-600 py-1 px-2 text-xs">{{$category->name}}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>