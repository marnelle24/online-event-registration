@section('title', $programme->title)
<x-app-layout>
    <div class="flex md:flex-row flex-col gap-4">
        <img src="{{$programme->thumbnail}}" alt="{{$programme->title}}" class="lg:rounded-lg object-cover bg-center rounded-tl-md rounded-tr-md lg:w-60 w-full h-48 border border-zinc-400 shadow-md" />
        <div>
            <h1 class="text-2xl text-slate-600 font-bold">{{$programme->title}}</h1>
            <table class="my-4">
                <tr>
                    <td class="text-md py-1 text-slate-600 flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600 capitalize overflow-ellipsis">
                        {{ $programme->getLocationAttribute() }}
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600 flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600">
                        {{ $programme->getProgrammeDatesAttribute() }}
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600">
                        <p class="text-md capitalize">
                            {{ $programme->getProgrammeTimesAttribute() }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600">
                        <p class="text-md uppercase">
                            {{ $programme->getFormattedPriceAttribute() }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="text-md py-1 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    </td>
                    <td class="text-md p-1 text-slate-600">
                        <p class="text-md">
                            {{ $programme->getTotalRegistrationsAttribute() }} / {{ $programme->limit > 0 ? $programme->limit : 'No limit' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="flex gap-3 pl-2 border-b-2 border-zinc-500/70 w-full overflow-x-auto">
        @php
            $tabs = [
                'dashboard' => 'Dashboard',
                'information' => 'Information',
                'speaker-trainer' => 'Speakers',
                'promotion' => 'Promotions',
                'promocode' => 'Promocodes',
                'registrants' => 'Registrants',
                'settings' => 'Settings',
                'breakout-session' => 'Breakout Sessions'
            ];
        @endphp
        @foreach($tabs as $tab => $label)
            @php
                $isActive = (request('p') === $tab || (empty(request('p')) && $tab === 'dashboard'));
                $tabColorToggle = $isActive ? 'bg-slate-700 text-white border-b-1 border-slate-600' : 'bg-white border-slate-500';
            @endphp
            <a href="{{ url()->current() }}?p={{ $tab }}" class="{{$tabColorToggle}} text-nowrap hover:bg-slate-700 hover:text-white duration-300 hover:scale-105 border border-b-0 px-3 py-2 rounded-tr-md rounded-tl-md text-md">{{ $label }}</a>
        @endforeach
    </div>
    <div class="flex gap-4 w-full md:mb-0 mb-12">
        {{-- <hr class="border border-zinc-500/70" /> --}}

        @if(request('p') === 'dashboard' || !request('p'))
            @livewire('admin.programme.dashboard.overview', ['programmeId' => $programme->id], key('programme-dashboard-overview-'.$programme->id))
        @endif
        
        @if(request('p') === 'information')
            @livewire('admin.programme.information-details', ['programmeId' => $programme->id], key('information-details'))
        @endif

        @if(request('p') === 'speaker-trainer')
            @livewire('admin.programme.speaker.all-speaker', ['programmeId' => $programme->id], key('all-speaker'))
        @endif

        @if(request('p') === 'promotion')
            @livewire('admin.promotion.all-promotion', ['programmeId' => $programme->id], key('all-promotion'))
        @endif
        
        @if(request('p') === 'promocode')
            @livewire('admin.promocode.all-promocode', ['programmeId' => $programme->id], key('all-promocode'))
        @endif

        @if(request('p') === 'registrants')
            @livewire('admin.registrant.index', ['programmeId' => $programme->id], key('registrant-index'))
        @endif

        @if(request('p') === 'settings')
            @livewire('admin.programme.settings-section', ['programmeId' => $programme->id], key('settings-section'))
        @endif

        @if(request('p') === 'breakout-session')
            @livewire('admin.programme.breakout-session', ['programmeId' => $programme->id], key('breakout-session'))
        @endif
    </div>
    <style>
        .ck-content {
            min-height:300px;
            /* background-color: #fafafa !important; */
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
    @push('script')
        @vite('resources/js/programme-dashboard-charts.js')
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
    @endpush
</x-app-layout> 

