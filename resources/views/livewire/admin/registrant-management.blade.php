<div>
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-8 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">Registrant Management</h4>
            <p class="text-sm text-slate-500">Manage registrants of the events and programmes</p>
        </div>
        <div class="flex lg:gap-3 gap-1">
            <button wire:click="exportCsv" 
                class="flex items-center gap-2 border border-slate-500 bg-slate-100 drop-shadow text-slate-500 hover:text-slate-200 hover:bg-slate-600 rounded-full hover:-translate-y-1 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Export CSV
            </button>
            <button wire:click="exportExcel" 
                class="flex items-center gap-2 shadow border border-blue-600/30 bg-green-700 drop-shadow text-slate-200 hover:bg-green-800 rounded-full hover:-translate-y-1 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
                Export Excel
            </button>
        </div>
    </div>

    <!-- Search and Filters Section -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
            <!-- Search -->
            <div class="lg:col-span-2 col-span-1">
                <label class="block text-sm font-medium text-slate-700 mb-2">Search</label>
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="search" 
                    placeholder="Search by name, email, registration code..."
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                />
            </div>

            <!-- Programme Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Programme</label>
                <select 
                    wire:model.live="programmeFilter" 
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                >
                    <option value="">All Programmes</option>
                    @foreach($programmes as $programme)
                        <option value="{{ $programme->id }}">{{ $programme->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Payment Status Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Payment Status</label>
                <select 
                    wire:model.live="paymentStatusFilter" 
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                >
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>

            <!-- Registration Type Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Registration Type</label>
                <select 
                    wire:model.live="registrationTypeFilter" 
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                >
                    <option value="">All Types</option>
                    <option value="individual">Individual</option>
                    <option value="group">Group</option>
                    <option value="group_member">Group Member</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="rounded-sm border border-stroke">
        <div class="max-w-full md:overflow-x-visible overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-slate-200 border border-slate-300 text-slate-500 text-left">
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByConfirmationCode">
                            Confirmation Code
                            @if($sortBy === 'confirmationCode')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByFirstName">
                            Name
                            @if($sortBy === 'firstName')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        {{-- <th class="p-4 font-bold">Contact</th> --}}
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByPaymentStatus">
                            Payment
                            @if($sortBy === 'paymentStatus')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold">Amount</th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByCreatedAt">
                            Registered
                            @if($sortBy === 'created_at')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByRegStatus">
                            Status
                            @if($sortBy === 'regStatus')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($registrants->count())
                        @foreach ($registrants as $registrant)
                            <tr class="hover:bg-slate-400/10 duration-300 border border-slate-300 dark:border-slate-700 bg-white">
                                <td class="p-4 pl-6 w-[15%]">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-sm text-slate-600">{{ $registrant->confirmationCode }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 truncate">
                                            {{ $registrant->title }} {{ $registrant->firstName }} {{ $registrant->lastName }}
                                        </span>
                                        <span class="text-xs text-slate-500 truncate">{{ $registrant->regCode }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex gap-1">

                                        <div class="flex justify-start">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-orange-100 text-orange-800 border-orange-600',
                                                    'free' => 'bg-yellow-100 text-yellow-800 border-yellow-600',
                                                    'pending_verification' => 'bg-orange-100 text-orange-800 border-orange-600',
                                                ];
                                                $statusColor = $statusColors[$registrant->paymentStatus] ?? 'bg-gray-100 text-gray-800 border-gray-600';
                                            @endphp
                                            @if($registrant->paymentStatus !== 'paid' && $registrant->paymentStatus !== 'pending_verification')
                                                <span class="px-3 py-1 text-xs rounded-full border {{ $statusColor }}">
                                                    {{ucfirst($registrant->paymentStatus)}}
                                                </span>
                                            @endif
                                        </div>
                                        @if($registrant->paymentOption == 'hitpay' && $registrant->paymentStatus === 'paid')
                                            <div class="w-8 h-8 flex justify-center items-center rounded-md bg-[#7C2278] p-1">
                                                <img src="{{ asset('images/PayNow.png') }}" alt="HitPay" class="w-full">
                                            </div>
                                        @elseif($registrant->paymentOption === 'card')
                                            <img src="{{ asset('images/card.png') }}" alt="Card" class="w-10 h-10">
                                        @elseif($registrant->paymentOption === 'bank_transfer')
                                            <svg class="w-8 h-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 508 508" xml:space="preserve" fill="#000000">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier"> 
                                                    <circle style="fill:#daac37;" cx="254" cy="254" r="254"></circle> 
                                                    <g> 
                                                        <rect x="134.8" y="182.4" style="fill:#FFFFFF;" width="46" height="169.2"></rect> 
                                                        <rect x="231.2" y="184.4" style="fill:#FFFFFF;" width="46" height="169.2"></rect> 
                                                        <rect x="327.6" y="184.4" style="fill:#FFFFFF;" width="46" height="169.2"></rect> 
                                                        <rect x="99.2" y="345.2" style="fill:#FFFFFF;" width="309.6" height="30.4"></rect> 
                                                        <polygon style="fill:#FFFFFF;" points="408.8,148 254.8,76.8 99.6,148 99.6,187.2 408.8,187.2 "></polygon> 
                                                    </g> 
                                                    <g> 
                                                        <polygon style="fill:#E6E9EE;" points="123.2,163.2 123.2,163.2 254.8,103.2 384.8,162.8 384.8,163.2 "></polygon> 
                                                        <path style="fill:#E6E9EE;" d="M320,187.2v13.2c0,2.4,2,4.4,4.4,4.4h52.4c2.4,0,4.4-2,4.4-4.4v-13.2H320z"></path> 
                                                        <path style="fill:#E6E9EE;" d="M223.6,187.2v13.2c0,2.4,2,4.4,4.4,4.4h52.4c2.4,0,4.4-2,4.4-4.4v-13.2H223.6z"></path> 
                                                        <path style="fill:#E6E9EE;" d="M127.2,187.2v13.2c0,2.4,2,4.4,4.4,4.4H184c2.4,0,4.4-2,4.4-4.4v-13.2H127.2z"></path> 
                                                        <path style="fill:#E6E9EE;" d="M320,345.2V332c0-2.4,2-4.4,4.4-4.4h52.4c2.4,0,4.4,2,4.4,4.4v13.2H320z"></path> 
                                                        <path style="fill:#E6E9EE;" d="M223.6,345.2V332c0-2.4,2-4.4,4.4-4.4h52.4c2.4,0,4.4,2,4.4,4.4v13.2H223.6z"></path> 
                                                        <path style="fill:#E6E9EE;" d="M127.2,345.2V332c0-2.4,2-4.4,4.4-4.4H184c2.4,0,4.4,2,4.4,4.4v13.2H127.2z"></path> 
                                                    </g> 
                                                </g>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col text-left">
                                        <span class="font-medium text-slate-600 dark:text-slate-200">
                                            ${{ number_format($registrant->netAmount, 2) }}
                                        </span>
                                        @if($registrant->promotion)
                                            <span class="text-xs text-green-600 dark:text-green-400">
                                                -${{ number_format($registrant->promotion->price, 2) }}
                                                {{ $registrant->promotion->title }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-slate-600 dark:text-slate-200">
                                            {{ $registrant->created_at->format('M j, Y') }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $registrant->created_at->format('g:i A') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-start">
                                        @php
                                            $regStatusColors = [
                                                'pending' => 'bg-orange-100 text-orange-800 border-orange-600',
                                                'paid' => 'bg-green-100 text-green-800 border-green-600',
                                                'confirmed' => 'bg-green-100 text-green-800 border-green-600',
                                            ];
                                            $statusColor = $regStatusColors[$registrant->regStatus] ?? 'bg-gray-100 text-gray-800 border-gray-600';
                                        @endphp
                                        <span class="px-3 py-1 text-xs rounded-full border {{ $statusColor }}">
                                            {{ ucfirst($registrant->regStatus) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        <button 
                                            wire:click="$dispatch('show-registrant-details', { registrantId: {{ $registrant->id }} })"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:-translate-y-0.5 duration-300"
                                            title="View Details"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </button>
                                        
                                        @if($registrant->paymentStatus === 'pending' && $registrant->paymentOption === 'bank_transfer')
                                            <button 
                                                wire:click="$dispatch('verify-payment', { registrantId: {{ $registrant->id }} })"
                                                class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 hover:-translate-y-0.5 duration-300"
                                                title="Verify Payment"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="group bg-white duration-300">
                            <td colspan="8" class="text-center">
                                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400 dark:text-slate-500 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <p class="text-slate-500 text-lg font-medium">No registrants found</p>
                                    <p class="text-slate-400 text-sm">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="flex lg:flex-row flex-col lg:items-center items-start lg:gap-2 gap-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Per Page</label>
                <select 
                    wire:model.live="perPage" 
                    class="py-1 px- w-20 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        {{ $registrants->links() }}
    </div>
</div>
