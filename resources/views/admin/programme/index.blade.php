@section('title', 'Programme Management')
<x-app-layout>
    <div class="flex justify-between gap-3 mb-8">
        <h4 class="text-2xl font-bold text-black dark:text-slate-600 capitalize">Programme Management</h4>
        <a href="{{ route('admin.programmes.create') }}" 
            class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-3 px-5 mr-2">
            Create Programme
        </a>
    </div>

    <form method="GET" action="{{ route('admin.programmes') }}" class="mb-4 lg:px-0 px-2">
        <input 
            type="search" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Search programmes..." 
            class="placeholder:opacity-60 border px-4 py-2 text-lg focus:outline-none focus:ring-0 rounded-none lg:w-1/2 w-full" >
    </form>
    <br />
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        @foreach ($programmes as $programme)
            <x-programme.card :programme="$programme" />
        @endforeach
    </div>
    <div class="mt-20">
        {{ $programmes->links() }}
    </div>
</x-app-layout>
