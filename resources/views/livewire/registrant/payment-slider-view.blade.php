<div x-data="{ showToolTip: false }" class="relative">
    <button 
        wire:click="openModal"
        @mouseover="showToolTip = true" 
        @mouseleave="showToolTip = false"
        class="hover:text-blue-500 hover:scale-110 duration-300 flex items-center"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
        </svg>
        <div 
            x-show="showToolTip" 
            x-transition 
            class="absolute top-full -left-6 mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg"
        >
            Payment
        </div>
    </button>

    @if ($show)
        <div 
            wire:click="closeModal"
            x-transition
            class="fixed inset-0 z-50"
        >
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50" @click="showModal = false">
            </div>
            <div class="absolute inset-y-0 right-0 lg:w-1/4 w-full bg-white shadow-lg transform transition-transform duration-300 overflow-auto" style="transform: translateX(0%)">
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-400/70 bg-slate-400">
                    <h2 class="text-white text-2xl uppercase font-light">Payment Details</h2>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900 text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-slate-800 hover:stroke-slate-500 hover:-translate-y-1 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-lg font-bold my-4">Payment Information Details</p>
                    <table class="border-x border-t border-slate-400 shadow w-full">
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Payment ID</td>
                            <td class="py-2 px-2 text-md">{{ '9rfwef9382338f645gfecdsd' }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Payment Date</td>
                            <td class="py-2 px-2 text-md">
                                {{ \Carbon\Carbon::parse('2025-07-10')->format('M j, Y') }}
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Amount</td>
                            <td class="py-2 px-2 text-md">{{ 'SGD'.number_format(40, 2) }} </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Payment Option</td>
                            <td class="py-2 px-2 text-md">{{ 'PayNow' }}</td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">Payment Remarks</td>
                            <td class="py-2 px-2 text-md">{{ 'ABCTEST_2025_Test_event_07-07-2025' }}</td>
                        </tr>
                    </table>

                    <br ./>
                    <p class="text-lg font-bold my-4">Registration Status</p>
                    <table class="border-x border-t border-slate-400 shadow w-full">
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">
                                Email Confirmation
                                <p class="inline-flex capitalize rounded-full bg-success bg-opacity-10 border border-green-700/20 px-3 py-0.5 text-sm font-medium text-success">
                                    {{'Sent'}}
                                </p>
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">
                                SMS Confirmation
                                <p class="inline-flex capitalize rounded-full bg-success bg-opacity-10 border border-green-700/20 px-3 py-0.5 text-sm font-medium text-success">
                                    {{'Sent'}}
                                </p>
                            </td>
                        </tr>
                        <tr class="border-b border-slate-400">
                            <td class="py-2 px-2 text-md">
                                Payment Validated by <span class="italic text-slate-400 font-bold capitalize">{{ $registrant->approvedBy }}</span>
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
    @endif
</div>
