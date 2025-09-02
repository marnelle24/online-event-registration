@section('title', 'Programme Management')
<x-app-layout>
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" x-transition:leave.duration.500ms
            class="mb-5 bg-green-300 bg-opacity-50 border border-green-600/70 text-green-600 p-4 rounded-md flex justify-between items-center">
            <span class="text-md">{{ session('success') }}</span>
            <button type="button" @click="show = false" class="ml-4 text-[30px] leading-none opacity-50 hover:opacity-75 duration-300" aria-label="Close">
                &times;
            </button>
        </div>
    @endif
    <div class="flex justify-between gap-3 mb-8">
        <h4 class="text-2xl font-bold text-slate-600 capitalize">Manage Programmes</h4>
    </div>

    <div class="flex items-center justify-between flex-wrap my-4 gap-4">
        <form method="GET" action="{{ route('admin.programmes') }}" class="flex-grow max-w-full sm:max-w-md">
            <input 
                type="search" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Search programmes..." 
                class="placeholder:opacity-60 border border-slate-300 px-4 py-2 text-md focus:ring-0 focus:border-slate-400 rounded-none w-full" />
        </form>
        <a href="{{ route('admin.programmes.create') }}" 
            class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-3 px-5 flex-shrink-0">
            Create Programme
        </a>
    </div>
    {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-6"> --}}
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        @if($programmes->isEmpty())
            <div class="p-4 text-center text-slate-500">
                No programmes found.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    @foreach ($programmes as $programme)
                        <tr class="transform hover:bg-slate-100/50 hover:shadow-md hover:-translate-y-1 transition-all duration-300 ease-in-out animate-fade-in border-b border-stroke dark:border-strokedark last:border-b-0">
                            <td class="p-4 flex gap-2 items-start flex-grow whitespace-nowrap">
                                @if(!$programme->hasMedia('thumbnail'))
                                    <div class="relative">
                                        <div class="w-18 h-18 md:w-20 md:h-20 flex items-center justify-center bg-slate-200 rounded-lg">
                                            <p class="text-2xl font-normal text-slate-400 tracking-widest">
                                                {{ Helper::getInitials($programme->title) }}
                                            </p>
                                        </div>
                                        @if($programme->active_promotion)
                                            <div class="absolute -top-2 -left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md animate-bounce">
                                                {{ $programme->active_promotion->title }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="relative">
                                        <img src="{{ $programme->getFirstMediaUrl('thumbnail') }}" 
                                            alt="thumbnail" 
                                            class="w-18 h-18 md:w-20 md:h-20 object-cover rounded-lg shadow-sm border border-slate-200" />
                                        @if($programme->active_promotion)
                                            <div class="absolute -top-2 -left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md animate-bounce">
                                                {{ $programme->active_promotion->title }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="flex flex-col">
                                    <a href="{{ route('admin.programmes.show', $programme->programmeCode) }}" class="text-md md:text-lg font-semibold text-slate-800 dark:text-slate-200 hover:text-orange-600 hover:-translate-y-1 duration-300">
                                        {{ Str::words($programme->title, 4) }}
                                    </a>
                                    <a href="#" class="hover:-translate-y-0.5 duration-300 dark:text-slate-400">
                                        <span class="text-xs text-slate-500 capitalize bg-slate-300/60 hover:bg-slate-300/80 px-2 py-1 rounded-md border border-slate-300 drop-shadow-sm hover:text-orange-600 ">
                                            {{ $programme->ministry->name }}
                                        </span>
                                    </a>
                                    <p class="text-md capitalize my-2 italic @if($programme->status === 'draft') text-slate-500 @elseif($programme->status === 'pending') text-red-500 @else text-green-500 @endif">
                                        {{ $programme->status }}
                                    </p>
                                </div>
                                <span class="text-[10px] text-slate-500 capitalize bg-slate-300/60 px-3 py-1 rounded-full">
                                    {{ $programme->type }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="flex-grow space-y-2 justify-start">
                                    <div class="flex gap-1 items-center text-slate-600 dark:text-slate-300">
                                        <p class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                            </svg>

                                        </p>
                                        @if($programme->limit > 0)
                                            <p class="text-sm capitalize">
                                                {{ $programme->getTotalRegistrationsAttribute() . ' / ' . $programme->limit }}
                                            </p>
                                        @else
                                            <p class="text-sm capitalize flex items-center">
                                                {{ $programme->getTotalRegistrationsAttribute() . ' / ' }} 
                                                <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" class="w-6 h-6">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier"> 
                                                        <path d="M20.288 9.463a4.856 4.856 0 0 0-4.336-2.3 4.586 4.586 0 0 0-3.343 1.767c.071.116.148.226.212.347l.879 1.652.134-.254a2.71 2.71 0 0 1 2.206-1.519 2.845 2.845 0 1 1 0 5.686 2.708 2.708 0 0 1-2.205-1.518L13.131 12l-1.193-2.26a4.709 4.709 0 0 0-3.89-2.581 4.845 4.845 0 1 0 0 9.682 4.586 4.586 0 0 0 3.343-1.767c-.071-.116-.148-.226-.212-.347l-.879-1.656-.134.254a2.71 2.71 0 0 1-2.206 1.519 2.855 2.855 0 0 1-2.559-1.369 2.825 2.825 0 0 1 0-2.946 2.862 2.862 0 0 1 2.442-1.374h.121a2.708 2.708 0 0 1 2.205 1.518l.7 1.327 1.193 2.26a4.709 4.709 0 0 0 3.89 2.581h.209a4.846 4.846 0 0 0 4.127-7.378z"></path> 
                                                    </g>
                                                </svg>
                                            </p>
                                        @endif
                                    </div>
                                </div>    
                            </td>

                            <td class="p-4 whitespace-nowrap">
                                <div class="flex-grow space-y-2 justify-start">
                                    <div class="flex gap-1 items-center text-slate-600 dark:text-slate-300">
                                        <p class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                        </p>
                                        <p class="text-sm capitalize">{{ $programme->getLocationAttribute() }}</p>
                                    </div>
                                    <div class="flex items-center gap-1 text-slate-600 dark:text-slate-300">
                                        <p class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                            </svg>
                                        </p>
                                        <p class="text-sm">{{ $programme->getProgrammeDatesAttribute() }}</p>
                                    </div>
                                    <div class="flex items-center gap-1 text-slate-600 dark:text-slate-300">
                                        <p class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </p>
                                        <p class="text-sm">{{ $programme->getProgrammeTimesAttribute() }}</p>
                                    </div>
                                </div>    
                            </td>
                            
                            <td class="p-4 gap-1 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    @if($programme->active_promotion)
                                        <p class="text-sm line-through text-slate-400">{{ $programme->formatted_price }}</p>
                                        <p class="text-sm font-semibold text-green-500">{{ $programme->discounted_price }}</p>
                                    @else
                                        <p class="text-sm uppercase">{{ $programme->formatted_price }}</p>
                                    @endif
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="flex md:flex-col gap-3 justify-end items-center">
                                    <a href="{{ route('admin.programmes.show', $programme->programmeCode) }}" 
                                    class="transform hover:scale-110 transition-all duration-300">
                                        <svg class="w-5 h-5 stroke-blue-500 hover:stroke-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.programmes.soft-delete', $programme->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this programme? This action cannot be undone.');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                title="Delete Programme"
                                                class="transform hover:scale-110 transition-all duration-300">
                                            <svg class="w-5 h-5 stroke-red-400 hover:stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
    <br />
    <div class="mt-4">
        {{ $programmes->links() }}
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @media (min-width: 768px) {
            .grid-cols-2 > * {
                animation-delay: calc(0.2s * var(--child-index, 0));
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.animate-fade-in');
            items.forEach((item, index) => {
                item.style.setProperty('--child-index', index);
                item.style.animationDelay = `${index * 0.1}s`;
                item.style.opacity = '1';
            });
        });
    </script>
</x-app-layout>
