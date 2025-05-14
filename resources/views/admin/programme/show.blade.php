@section('title', $programme->title)
<x-app-layout>
    <div class="flex lg:flex-row flex-col gap-4">
        <img src="{{$programme->thumbnail}}" alt="{{$programme->title}}" class="lg:rounded-full rounded-tl-md rounded-tr-md lg:w-48 w-full h-48 border border-zinc-400 shadow-md" />
        <div class="lg:w-3/4 w-full">
            {{-- @dump($programme) --}}
            <div class="flex justify-between gap-1">
                <h1 class="text-2xl text-slate-600 drop-shadow font-bold">{{$programme->title}}</h1>
                <a href="{{route('admin.programmes.edit', $programme->id)}}" class="text-xs hover:bg-slate-200 hover:scale-105 duration-300 px-3 py-2 border border-slate-400/70 bg-slate-300">Edit</a>
            </div>
            <table class="my-4">
                <tr>
                    <td class="text-md py-1 text-slate-600 dark:text-white flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600 dark:text-white capitalize overflow-ellipsis">
                        {{ $programme->programmeLocation }}
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600 dark:text-white flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600 dark:text-white {{$programme->customDate ? '' : 'uppercase'}}">
                        {{ $programme->programmeDates }}
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600 dark:text-white">
                        <p class="text-md capitalize">
                            {{ $programme->programmeTimes }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600 dark:text-white">
                        <p class="text-md uppercase">
                            {{ $programme->programmePrice }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600 dark:text-white">
                        <p class="text-md">
                            40 / {{ $programme->limit > 0 ? $programme->limit : 'No limit' }}
                        </p>
                    </td>
                </tr>
            </table>
            <div class="flex gap-3">
                <a href="{{ url()->current() }}?p=" class="bg-zinc-200 hover:bg-sky-200 duration-300 hover:scale-105 border border-slate-500 border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Programme Details</a>
                <a href="{{ url()->current() }}?p=speaker-trainer" class="@if(request('p') === 'speaker-trainer') bg-sky-200 scale-105 @else bg-zinc-200 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-slate-500 border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Speakers & Trainers</a>
                <a href="{{ url()->current() }}?p=promotion" class="@if(request('p') === 'promotion') bg-sky-200 scale-105 @else bg-zinc-200 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-slate-500 border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Promotions & Deals</a>
                <a href="{{ url()->current() }}?p=promocode" class="@if(request('p') === 'promocode') bg-sky-200 scale-105 @else bg-zinc-200 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-slate-500 border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Promo Codes</a>
            </div>
            <hr class="border border-zinc-500/70" />
            
            @if(!request('p'))
            <div>
                @if($programme->excerpt)
                    <div class="mt-4">
                        <p class="text-sm italic text-slate-500 mb-1">Except:</p>
                        <div class="p-4 border border-slate-600/70 bg-zinc-50 rounded-md text-sm">
                            {{ $programme->excerpt }}
                        </div>
                    </div>
                @endif
    
                @if($programme->description)
                    <div class="mt-4">
                        <p class="text-sm italic text-slate-500 mb-1">Description:</p>
                        <div class="ck-content p-8 border border-slate-600/70 bg-zinc-200/30 rounded-md text-sm">
                            {!! $programme->description !!}
                        </div>
                    </div>
                @endif
    
                <div class="mt-8 bg-white/60 p-8 border border-slate-400">
                    <p class="text-xl font-bold mb-1">Other Information</p>  
                    <div class="flex lg:flex-row flex-col gap-3">
                        <div class="lg:w-1/2 w-full">
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">Admin Fee Applied</p>
                                <p class="text-slate-700">{{$programme->adminFee > 0 ? 'SGD'.$programme->adminFee : 'No Admin Fee'}}</p>
                            </div>
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">Registration Max Limit</p>
                                <p class="text-slate-700">{{$programme->limit > 0 ? $programme->limit.' participants' : 'No limit'}}</p>
                            </div>
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">Registration Validiity</p>
                                <p class="text-slate-700">{{ Carbon\Carbon::parse($programme->activeUntil)->format('F j, Y @ g:i a')}}</p>
                            </div>
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">External Link</p>
                                <p class="text-xs italic text-slate-400 mb-1">3rd party registration form for this programme</p>
                                <a href="{{$programme->externalUrl}}" class="text-blue-500 drop-shadow-sm hover:text-blue-400 hover:-translate-y-1 duration-300">{{$programme->externalUrl}}</a>
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">Contact Person</p>
                                <p class="text-slate-700">{{$programme->contactPerson}}</p>
                            </div>
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">Contact Number</p>
                                <p class="text-slate-700">{{$programme->contactNumber}}</p>
                            </div>
                            <div class="flex flex-col mt-4">
                                <p class="text-sm font-bold text-slate-500">Contact Email</p>
                                <p class="text-slate-700">{{$programme->contactEmail}}</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="mt-4">
                    <p class="text-sm italic text-slate-500 mb-1">Categories:</p>
                    <div class="flex flex-wrap whitespace-normal gap-1">
                        @foreach ($programme->categories as $category)
                            <p class="py-1 px-3 rounded-full text-sm text-white bg-primary hover:bg-primary/90">{{$category->name}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if(request('p') === 'speaker-trainer')
                <div>
                    This is Speaker & Trainer Area
                </div>
            @endif

            @if(request('p') === 'promotion')
                <div>
                    This is Promotion Area
                </div>
            @endif
            
            @if(request('p') === 'promocode')
                <div>
                    This is Promo Code Area
                </div>
            @endif
            
        </div>
    </div>
    <style>
        .ck-content {
            min-height:300px;
            background-color: #fafafa !important;
        }
        .ck-content a {
            color:#3989f1 !important;
            text-decoration: underline !important;
        }
        .ck-content ol, .ck-content ul {
            padding-inline: 30px !important;
        }

        .ck-content h2 {
            font-size: 40px !important;
        } 
        .ck-content h3 {
            font-size: 30px !important;
        }
        .ck-content h4 {
            font-size: 20px !important;
        }
    </style>
</x-app-layout> 

