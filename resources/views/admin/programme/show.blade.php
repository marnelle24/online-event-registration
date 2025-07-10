@section('title', $programme->title)
<x-app-layout>

    @if(session('success'))
        <div x-data="{ showAlert: true }" x-show="showAlert"
            class="bg-green-300/30 flex justify-between items-center border border-green-600/50 text-green-800 px-4 py-3 rounded relative mb-8">
            {{ session('success') }}
            <button type="button" class="close hover:scale-125 duration-300" data-dismiss="alert" aria-label="Close" x-on:click="showAlert = false">
                <span class="text-2xl text-green-700" aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="flex lg:flex-row flex-col gap-4">
        <img src="{{$programme->thumbnail}}" alt="{{$programme->title}}" class="lg:rounded-full rounded-tl-md rounded-tr-md lg:w-48 w-full h-48 border border-zinc-400 shadow-md" />
        <div class="lg:w-3/4 w-full">
            {{-- @dump($programme) --}}
            <div class="flex justify-between gap-1">
                <h1 class="text-2xl text-slate-600 drop-shadow font-bold">{{$programme->title}}</h1>
                <div class="flex gap-2">
                    <a href="{{route('admin.programmes.edit', $programme->id)}}" class="hover:bg-slate-200 rounded-full hover:scale-105 duration-300 px-4 py-2 border border-slate-400/70 bg-slate-300">Edit</a>
                    @if($programme->status === 'published')
                        <p class="capitalize flex items-center justify-center border border-green-600 bg-green-500 text-white drop-shadow rounded-full px-4 py-1">{{$programme->status}}</p>
                    @else
                        <p class="capitalize flex items-center justify-center border border-slate-600 bg-slate-500 text-white drop-shadow rounded-full px-4 py-1">{{$programme->status}}</p>
                    @endif
                </div>
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
            <div class="flex gap-3 pl-2 border-b-2 border-zinc-500/70">
                <a href="{{ url()->current() }}?p=dashboard" class="@if(request('p') === 'dashboard') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Dashboard</a>
                <a href="{{ url()->current() }}?p=information" class="@if(request('p') === 'information') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Information</a>
                <a href="{{ url()->current() }}?p=speaker-trainer" class="@if(request('p') === 'speaker-trainer') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Speakers</a>
                <a href="{{ url()->current() }}?p=promotion" class="@if(request('p') === 'promotion') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Promotions</a>
                <a href="{{ url()->current() }}?p=promocode" class="@if(request('p') === 'promocode') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Promos</a>
                <a href="{{ url()->current() }}?p=registrants" class="@if(request('p') === 'registrants') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Registrants</a>
                <a href="{{ url()->current() }}?p=settings" class="@if(request('p') === 'settings') bg-sky-200 border-b-1 border-sky-600 scale-105 @else bg-zinc-200 border-slate-500 @endif hover:bg-sky-200 duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">Settings</a>
            </div>
            {{-- <hr class="border border-zinc-500/70" /> --}}

            @if(request('p') === 'dashboard' || !request('p'))
                <div class="lg:px-0 px-4 py-8 flex flex-col">
                    <div class="grid grid-cols-2 gap-4">
                        {{-- card 1 --}}
                        <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                                <svg class="fill-primary dark:fill-white" width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.18418 8.03751C9.31543 8.03751 11.0686 6.35313 11.0686 4.25626C11.0686 2.15938 9.31543 0.475006 7.18418 0.475006C5.05293 0.475006 3.2998 2.15938 3.2998 4.25626C3.2998 6.35313 5.05293 8.03751 7.18418 8.03751ZM7.18418 2.05626C8.45605 2.05626 9.52168 3.05313 9.52168 4.29063C9.52168 5.52813 8.49043 6.52501 7.18418 6.52501C5.87793 6.52501 4.84668 5.52813 4.84668 4.29063C4.84668 3.05313 5.9123 2.05626 7.18418 2.05626Z" fill=""/>
                                    <path d="M15.8124 9.6875C17.6687 9.6875 19.1468 8.24375 19.1468 6.42188C19.1468 4.6 17.6343 3.15625 15.8124 3.15625C13.9905 3.15625 12.478 4.6 12.478 6.42188C12.478 8.24375 13.9905 9.6875 15.8124 9.6875ZM15.8124 4.7375C16.8093 4.7375 17.5999 5.49375 17.5999 6.45625C17.5999 7.41875 16.8093 8.175 15.8124 8.175C14.8155 8.175 14.0249 7.41875 14.0249 6.45625C14.0249 5.49375 14.8155 4.7375 15.8124 4.7375Z" fill=""/>
                                    <path d="M15.9843 10.0313H15.6749C14.6437 10.0313 13.6468 10.3406 12.7874 10.8563C11.8593 9.61876 10.3812 8.79376 8.73115 8.79376H5.67178C2.85303 8.82814 0.618652 11.0625 0.618652 13.8469V16.3219C0.618652 16.975 1.13428 17.4906 1.7874 17.4906H20.2468C20.8999 17.4906 21.4499 16.9406 21.4499 16.2875V15.4625C21.4155 12.4719 18.9749 10.0313 15.9843 10.0313ZM2.16553 15.9438V13.8469C2.16553 11.9219 3.74678 10.3406 5.67178 10.3406H8.73115C10.6562 10.3406 12.2374 11.9219 12.2374 13.8469V15.9438H2.16553V15.9438ZM19.8687 15.9438H13.7499V13.8469C13.7499 13.2969 13.6468 12.7469 13.4749 12.2313C14.0937 11.7844 14.8499 11.5781 15.6405 11.5781H15.9499C18.0812 11.5781 19.8343 13.3313 19.8343 15.4625V15.9438H19.8687Z" fill=""/>
                                </svg>

                            </div>

                            <div class="mt-4 flex items-end justify-between">
                            <div>
                                <h4 class="text-title-md font-bold text-black dark:text-white">140</h4>
                                <span class="text-sm font-medium">Total Registrants</span>
                            </div>

                            <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                                0.43%
                                <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""/>
                                </svg>
                            </span>
                            </div>
                        </div>
                        {{-- card 2 --}}
                        <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                                <svg class="fill-primary dark:fill-white" width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.7531 16.4312C10.3781 16.4312 9.27808 17.5312 9.27808 18.9062C9.27808 20.2812 10.3781 21.3812 11.7531 21.3812C13.1281 21.3812 14.2281 20.2812 14.2281 18.9062C14.2281 17.5656 13.0937 16.4312 11.7531 16.4312ZM11.7531 19.8687C11.2375 19.8687 10.825 19.4562 10.825 18.9406C10.825 18.425 11.2375 18.0125 11.7531 18.0125C12.2687 18.0125 12.6812 18.425 12.6812 18.9406C12.6812 19.4219 12.2343 19.8687 11.7531 19.8687Z" fill="" />
                                    <path d="M5.22183 16.4312C3.84683 16.4312 2.74683 17.5312 2.74683 18.9062C2.74683 20.2812 3.84683 21.3812 5.22183 21.3812C6.59683 21.3812 7.69683 20.2812 7.69683 18.9062C7.69683 17.5656 6.56245 16.4312 5.22183 16.4312ZM5.22183 19.8687C4.7062 19.8687 4.2937 19.4562 4.2937 18.9406C4.2937 18.425 4.7062 18.0125 5.22183 18.0125C5.73745 18.0125 6.14995 18.425 6.14995 18.9406C6.14995 19.4219 5.73745 19.8687 5.22183 19.8687Z" fill="" />
                                    <path d="M19.0062 0.618744H17.15C16.325 0.618744 15.6031 1.23749 15.5 2.06249L14.95 6.01562H1.37185C1.0281 6.01562 0.684353 6.18749 0.443728 6.46249C0.237478 6.73749 0.134353 7.11562 0.237478 7.45937C0.237478 7.49374 0.237478 7.49374 0.237478 7.52812L2.36873 13.9562C2.50623 14.4375 2.9531 14.7812 3.46873 14.7812H12.9562C14.2281 14.7812 15.3281 13.8187 15.5 12.5469L16.9437 2.26874C16.9437 2.19999 17.0125 2.16562 17.0812 2.16562H18.9375C19.35 2.16562 19.7281 1.82187 19.7281 1.37499C19.7281 0.928119 19.4187 0.618744 19.0062 0.618744ZM14.0219 12.3062C13.9531 12.8219 13.5062 13.2 12.9906 13.2H3.7781L1.92185 7.56249H14.7094L14.0219 12.3062Z" fill="" />
                                </svg>
                            </div>

                            <div class="mt-4 flex items-end justify-between">
                            <div>
                                <h4 class="text-title-md font-bold text-black dark:text-white">$3.456K</h4>
                                <span class="text-sm font-medium">Total Revenue</span>
                            </div>

                            <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                                1.50%
                                <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""/>
                                </svg>
                            </span>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="col-span-12 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-8">
                        <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap">
                            <div class="flex w-full flex-wrap gap-3 sm:gap-5">
                                <div class="flex min-w-47.5">
                                    <span class="mr-2 mt-1 flex h-4 w-full max-w-4 items-center justify-center rounded-full border border-primary">
                                        <span class="block h-2.5 w-full max-w-2.5 rounded-full bg-primary"></span>
                                    </span>
                                    <div class="w-full">
                                        <p class="font-semibold text-primary">Total Revenue</p>
                                        <p class="text-sm font-medium">12/04/2025 - 12/05/2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div> --}}
                        <div id="chartOne" class="-ml-5"></div>
                        {{-- </div> --}}
                    </div>
                </div>
            @endif
            
            @if(request('p') === 'information')
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
                @livewire('speaker.index', ['programmeSpeakers' => $programme->speakers, 'programmeId' => $programme->id])
            @endif

            @if(request('p') === 'promotion')
                @livewire('promotion.index', ['programmeId' => $programme->id])
            @endif
            
            @if(request('p') === 'promocode')
                @livewire('promocode.index', ['programmeId' => $programme->id])
            @endif

            @if(request('p') === 'registrants')
                @livewire('registrant.index', ['programmeId' => $programme->id])
            @endif

            @if(request('p') === 'settings')
                @livewire('programme.settings-section', ['programmeId' => $programme->id])
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
    @push('script')
        @vite('resources/js/programme-dashboard-graph-1.js')
    @endpush
</x-app-layout> 

