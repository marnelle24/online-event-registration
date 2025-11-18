<div x-cloak x-data="{ show: false, showToolTip: false }" class="relative">
    <button 
        @click="show = true"
        @mouseover="showToolTip = true" 
        @mouseleave="showToolTip = false"
        class="hover:text-blue-500 hover:scale-110 duration-300 flex items-center"
    >
        <svg
            class="fill-current w-5 h-5"
            width="18"
            height="18"
            viewBox="0 0 18 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z" fill=""/>
            <path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z" fill=""/>
        </svg>
        <div 
            x-show="showToolTip" 
            x-transition 
            class="absolute top-full -left-1 mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50"
        >
            Details
        </div>
    </button>

    <!-- Backdrop and Slide-over Modal -->
    <div 
        x-show="show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50"
        x-cloak
    >
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50" @click="show = false">
        </div>
        
        <!-- Slide-over Modal -->
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute inset-y-0 right-0 lg:w-1/4 w-full bg-white shadow-xl overflow-auto">
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-400/70 bg-slate-400">
                    <h2 class="text-white text-2xl uppercase font-light">Registrant Details</h2>
                    <button 
                        @click="show = false" 
                        class="text-gray-600 hover:text-gray-900 text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-slate-800 hover:stroke-slate-500 hover:-translate-y-1 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-lg font-bold my-4">Personal Information</p>
                    <table class="border-x border-t border-slate-400 shadow w-full">
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Reg Code</td>
                            <td class="py-2 px-2 text-md">{{ $registrant->confirmationCode }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">NRIC</td>
                            <td class="py-2 px-2 text-md">{{ $registrant->nric }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Name</td>
                            <td class="py-2 px-2 text-md">{{ $registrant->title }} {{ $registrant->firstName }} {{ $registrant->lastName }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Email</td>
                            <td class="py-2 px-2 text-md">{{ $registrant->email }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Contact No</td>
                            <td class="py-2 px-2 text-md">{{ $registrant->contactNumber }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Address</td>
                            <td class="py-2 px-2 text-md">
                                {{ $registrant->address }}
                                {{ $registrant->city }}
                                {{ $registrant->postalCode }}
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Church</td>
                            <td class="py-2 px-2 text-md">
                                {{ 'New Creation Church' }}
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Reg Date</td>
                            <td class="py-2 px-2 text-md">
                                {{ \Carbon\Carbon::parse($registrant->created_at)->format('M j, Y') }}
                            </td>
                        </tr>
                    </table>

                    <br ./>
                    <p class="text-lg font-bold my-4">Registration Status</p>
                    <table class="border-x border-t border-slate-400 shadow w-full">
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">
                                Status
                                <p class="inline-flex capitalize rounded-full bg-success bg-opacity-10 border border-green-700/20 px-3 py-0.5 text-sm font-medium text-success">
                                    {{$registrant->regStatus}}
                                </p>
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">
                                Validated & Approved by <span class="italic text-slate-400 font-bold capitalize">{{ $registrant->approvedBy }}</span>
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md text-slate-700">
                                Validated on <span class="italic text-slate-400 font-bold">{{ \Carbon\Carbon::parse($registrant->approvedDate)->format('M j, Y') }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
