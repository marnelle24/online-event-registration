@section('title', 'Speaker Management')
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
    @livewire('speaker.all-speaker', key('all-speakers'))
</x-app-layout> 