@section('title', 'User Management')
<x-app-layout>
    <div class="flex justify-between gap-3 mb-8">
        <h4 class="text-2xl font-bold text-black dark:text-slate-600 capitalize">User Management</h4>
        <a href="{{ route('admin.users.create') }}" 
            class="shadow border border-slate-600/30 bg-slate-300 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:bg-slate-500 dark:hover:bg-slate-600 rounded-full hover:-translate-y-1 duration-300 py-3 px-5">
            Add New User
        </a>
    </div>
    <div class="lg:w-1/4 w-full my-6">
        <form action="{{ route('admin.users') }}" method="get">
            <input 
                name="search" 
                type="search" 
                value="{{ old('search', $searchQuery) }}"
                class="text-slate-700 dark:text-slate-100 w-full py-3 placeholder:text-slate-500 dark:placeholder:text-slate-300 border-slate-400 dark:border-slate-600/60 bg-slate-200 dark:bg-slate-500 rounded-none placeholder:text-gray-300 focus:outline-none focus:ring-0" 
                placeholder="Search User">
        </form>
    </div>
    
    <div class="rounded-sm border border-stroke dark:border-strokedark">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-slate-200 dark:bg-slate-600 border border-slate-300 dark:border-slate-700 text-slate-500 dark:text-zinc-100 text-left">
                        <th class="p-6 font-bold xl:pl-11">
                            Name
                        </th>
                        <th class="p-6 font-bold">
                            Email
                        </th>
                        <th class="p-6 font-bold text-center">
                            Status
                        </th>
                        <th class="p-6 font-bold text-center">
                            &nbsp;
                        </th>
                        <th class="p-6 font-bold">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($users) )
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-400/10 dark:hover:bg-slate-500/80 duration-300 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-500">
                                <td class="p-4 pl-9 dark:border-strokedark xl:pl-11 flex gap-2 items-center">
                                    <p class="w-8 h-8 border border-zinc-800/40 dark:border-zinc-100/40 text-xs font-bold rounded-full text-slate-500 dark:text-slate-100 text-center flex items-center justify-center bg-slate-100 dark:bg-slate-400">
                                        {{ Helper::getInitials($user->name) }}
                                    </p>
                                    <h5 class="font-medium text-slate-600 dark:text-slate-200">{{ $user->name }}</h5>
                                </td>
                                <td class="px-4 py-5 dark:border-strokedark">
                                    <p class="font-medium dark:text-slate-200 text-slate-600 italic">{{ $user->email }}</p>
                                </td>
                                <td class="w-24 px-4 py-5 dark:border-strokedark">
                                    <div class="flex justify-center items-center">
                                        <p class="px-3 py-1 text-xs rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800 border border-green-600/60' : 'bg-red-100 text-red-800 border border-red-600/60' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="w-24 px-4 py-5 dark:border-strokedark">
                                    <div class="flex justify-center items-center">
                                        <p class="px-3 py-1 text-sm uppercase tracking-wider {{ $user->role == 'admin' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $user->role == 'admin' ? 'Admin' : 'User' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="w-24 px-4 py-5 dark:border-strokedark">
                                    <div class="flex justify-end items-center space-x-3.5">
                                        <button class="text-slate-500 dark:text-slate-200 hover:-translate-y-0.5 duration-300">
                                            <a href="{{ route('admin.users.show', $user->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                                </svg>
                                            </a>
                                        </button>
                                        
                                        {{-- <button class="text-danger dark:text-neutral-300 hover:-translate-y-0.5 duration-300">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z" fill="" />
                                                <path d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z" fill="" />
                                                <path d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z" fill="" />
                                                <path d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z" fill="" />
                                            </svg>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="hover:bg-neutral-100 dark:hover:bg-slate-700">
                            <td colspan="5" class="text-center py-5">
                                <i class="text-neutral-500 dark:text-neutral-300">No records found</i>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $users->links('vendor.pagination.custom-pagination') }}
    </div>
</x-app-layout>
