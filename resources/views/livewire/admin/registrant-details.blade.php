<div>
    @if($showModal && $registrant)
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <!-- Modal Content -->
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b border-slate-400/60 from-slate-500 to-slate-400 bg-gradient-to-r">
                    <h3 class="text-xl font-semibold text-slate-800 bg-clip-text text-transparent bg-gradient-to-r from-slate-100 to-white">
                        Registration Details - {{ $registrant->regCode }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-500 hover:text-slate-100 scale-125 hover:scale-150 duration-300 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <h4 class="flex gap-1 items-center text-lg from-slate-200 via-slate-100 to-white bg-gradient-to-r font-semibold text-slate-500 p-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Personal Information
                    </h4>
                    <div class="flex justify-between w-full items-start">
                        <div class="flex items-center gap-2">
                            <p class="lg:text-2xl text-xl font-bold text-white rounded-full lg:w-14 lg:h-14 w-10 h-10 flex items-center justify-center from-sky-300 to-sky-400 bg-gradient-to-r">
                                {{Helper::getInitials($registrant->firstName . ' ' . $registrant->lastName)}}
                            </p>
                            <h1 class="text-2xl font-bold text-slate-500">
                                {{ ($registrant->title ? $registrant->title.'.' : '') . ' ' . $registrant->firstName . ' ' . $registrant->lastName }}
                            </h1>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:pl-2 mt-5">
                        <div>
                            <label class="block text-sm text-slate-500">NRIC</label>
                            <p class="text-slate-800 text-md font-medium">{{ $registrant->nric ?: 'Not provided' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-500">Complete Name</label>
                            <p class="text-slate-800 text-md font-medium">{{ $registrant->firstName }} {{ $registrant->lastName }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-500">Email</label>
                            <p class="text-slate-800 text-md font-medium">{{ $registrant->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-500">Contact Number</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $registrant->contactNumber }}</p>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm text-slate-500">Address</label>
                            <p class="text-slate-800 text-md font-medium">
                                {{ $registrant->address ? $registrant->address.',':'' }} 
                                {{ $registrant->city ? $registrant->city.',':'' }} 
                                {{ $registrant->postalCode }}
                            </p>
                        </div>
                    </div>

                    <h4 class="flex gap-1 items-center text-lg from-slate-200 via-slate-100 to-white bg-gradient-to-r font-semibold text-slate-500 mt-12 p-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        Registration Information
                    </h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:pl-2 mt-5">
                        <div class="col-span-2 flex gap-2">
                            @if($registrant->programme->thumb)
                                <img src="{{ $registrant->programme->getFirstMediaUrl('thumbnail') }}" alt="{{ $registrant->programme->title }}" class="w-14 h-14 rounded-full">
                            @else
                                <p class="text-2xl rounded-full lg:w-14 lg:h-14 w-10 h-10 flex items-center justify-center from-sky-300 to-sky-400 bg-gradient-to-r text-white font-medium">{{Helper::getInitials($registrant->programme->title)}}</p>
                            @endif
                            <div>
                                <p class="text-slate-800 lg:text-2xl text-xl leading-snug font-medium mb-2">{{ $registrant->programme->title }}</p>
                                <p class="lg:text-sm text-xs text-slate-500"><span class="font-light text-xs tracking-wider rounded-lg bg-slate-100 py-1 font-mono border border-slate-300 px-3">{{ 'Code: '.$registrant->programme->programmeCode }}</span></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            {{-- Programme Details --}}
                                <div>
                                    <label class="block text-sm text-slate-500">Schedule Date</label>
                                    <p class="text-slate-800 text-md font-medium">{{ $registrant->programme->programme_dates }}</p>
                                </div>
                                @if($registrant->programme->startTime)
                                    <div>
                                        <label class="block text-sm text-slate-500">Time</label>
                                        <p class="text-slate-800 text-md font-medium">{{ $registrant->programme->programme_times }}</p>
                                    </div>
                                @endif
                                @if($registrant->programme->address)
                                    <div>
                                        <label class="block text-sm text-slate-500">Venue</label>
                                        <p class="text-slate-800 text-md font-medium">{{ $registrant->programme->location }}</p>
                                    </div>
                                @endif
                                @if($registrant->programme->ministry)
                                    <div>
                                        <label class="block text-sm text-slate-500">Ministry</label>
                                        <p class="text-slate-800 text-md font-medium">{{ $registrant->programme->ministry->name }}</p>
                                    </div>
                                @endif
                                @if($registrant->programme->categories->count() > 0)
                                    <div>
                                        <label class="block text-sm text-slate-500">Categories</label>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($registrant->programme->categories as $category)
                                                <span class="px-2 py-1 text-xs bg-slate-100 text-slate-600 rounded-full border border-slate-300">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-sm text-slate-500">Registration Code</label>
                                    <p class="text-slate-800 text-md font-medium">{{ $registrant->regCode }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-500">Confirmation Code</label>
                                    <p class="text-slate-800 text-md font-medium">{{ $registrant->confirmationCode }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-500">Registration Type</label>
                                    <p class="text-slate-800 text-md font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $registrant->registrationType)) }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-500 mb-1">Registration Status</label>
                                    <span class="px-3 py-1 text-xs rounded-full border border-green-600 bg-green-100 text-green-700 font-light uppercase">
                                        {{ ucfirst($registrant->regStatus) }}
                                    </span>
                                </div>
                                @if($registrant->groupRegistrationID)
                                    <div>
                                        <label class="block text-sm text-slate-500">Group Registration ID</label>
                                        <p class="text-slate-800 text-md font-medium">{{ $registrant->groupRegistrationID }}</p>
                                    </div>
                                @endif
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <h4 class="flex gap-1 items-center text-lg from-slate-200 via-slate-100 to-white bg-gradient-to-r font-semibold text-slate-500 mt-12 p-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        Payment Information
                    </h4>
                    <div class="mt-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm text-slate-500 mb-1">Payment Status</label>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-600',
                                        'paid' => 'bg-green-100 text-green-800 border-green-600',
                                        'failed' => 'bg-red-100 text-red-800 border-red-600',
                                        'refunded' => 'bg-gray-100 text-gray-800 border-gray-600'
                                    ];
                                    $statusColor = $statusColors[$registrant->paymentStatus] ?? 'bg-gray-100 text-gray-800 border-gray-600';
                                @endphp
                                <span class="px-3 py-1 text-xs rounded-full border {{ $statusColor }}">
                                    {{ ucfirst($registrant->paymentStatus) }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm text-slate-500 mb-1">Payment Option</label>
                                <p class="text-slate-800 text-md font-medium">{{ ucfirst(str_replace('_', ' ', $registrant->paymentOption)) }}</p>
                            </div>

                            <div>
                                <label class="block text-sm text-slate-500 mb-1">Standard Price</label>
                                <p class="text-slate-800 text-md font-medium">${{ number_format($registrant->price, 2) }}</p>
                            </div>

                            <div>
                                <label class="block text-sm text-slate-500 mb-1">Net Amount</label>
                                <p class="text-slate-800 text-md font-medium">${{ number_format($registrant->netAmount, 2) }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- @dump($registrant->promocode) --}}

                            @if($registrant->promocode)
                                <div>
                                    <label class="block text-sm text-slate-500 mb-1">Applied Promocode</label>
                                    <span class="px-3 py-1 text-xs rounded-full border text-md font-medium bg-green-100 text-green-800 border-green-600">{{ $registrant->promocode->promocode }}</span>
                                </div>
                            @endif
                            @if($registrant->promotion)
                                <div>
                                    <label class="block text-sm text-slate-500 mb-1">Applied Promotion</label>
                                    <span class="px-3 py-1 text-xs rounded-full border text-md font-medium bg-green-100 text-green-800 border-green-600">{{ $registrant->promotion->title ?? 'Test Promotion' }}</span>
                                </div>
                            @endif
                            {{-- <div>
                                <label class="block text-sm text-slate-500 mb-1">Applied Discount</label>
                                @if($registrant->promocode)
                                    <p class="text-slate-800 text-md font-medium">Promocode: {{ $registrant->promocode->code }}</p>
                                @elseif($registrant->promotion)
                                    <p class="text-slate-800 text-md font-medium">Promotion: {{ $registrant->promotion->title }}</p>
                                @else
                                    <p class="text-slate-800 text-md font-medium">Manual Adjustment</p>
                                @endif
                            </div> --}}
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @if($registrant->paymentReferenceNo)
                                <div>
                                    <label class="block text-sm text-slate-500 mb-1">Payment Reference</label>
                                    <p class="text-slate-800 text-md font-medium">{{ $registrant->paymentReferenceNo }}</p>
                                </div>
                            @endif

                            @if($registrant->payment_transaction_id)
                                <div class="col-span-2">
                                    <label class="block text-sm text-slate-500 mb-1">Payment Transaction ID</label>
                                    <a href="#" target="_blank" class="text-sky-600 hover:text-sky-500 hover:underline duration-300 transition-all text-md font-medium">{{ $registrant->payment_transaction_id }}</a>
                                </div>
                            @endif
    
                            @if($registrant->payment_completed_at)
                                <div>
                                    <label class="block text-sm text-slate-500 mb-1">Payment Completed</label>
                                    <p class="text-slate-800 text-md font-medium">{{ $registrant->payment_completed_at->format('M j, Y g:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Group Members (if applicable) -->
                    @php
                        $groupMembers = $registrant->groupMembers();
                    @endphp
                    @if($registrant->isMainRegistrant() && $groupMembers->count() > 0)
                        <h4 class="flex gap-1 items-center text-lg from-slate-200 via-slate-100 to-white bg-gradient-to-r font-semibold text-slate-500 mt-12 p-2 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            Group Members ({{ $groupMembers->count() }})
                        </h4>
                        <div class="space-y-4">
                            <div class="overflow-x-auto border border-slate-200 rounded-lg p-2">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-slate-200/60">
                                            <th class="p-3 text-left">Name</th>
                                            <th class="p-3 text-left">Email</th>
                                            <th class="p-3 text-left">Registration Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groupMembers as $member)
                                            <tr class="border-b border-slate-200 hover:bg-slate-100 duration-300 transition-all">
                                                <td class="p-3">{{ $member->title }} {{ $member->firstName }} {{ $member->lastName }}</td>
                                                <td class="p-3">{{ $member->email }}</td>
                                                <td class="p-3">{{ $member->regCode }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Extra Fields (if any) -->
                    @if($registrant->extraFields && count($registrant->extraFields) > 0)
                        <div class="mt-6 space-y-4">
                            <h4 class="flex gap-1 items-center text-lg from-slate-200 via-slate-100 to-white bg-gradient-to-r font-semibold text-slate-500 mt-12 p-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                Additional Information
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($registrant->extraFields as $key => $value)
                                    <div>
                                        <label class="block text-sm text-slate-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                        <p class="text-slate-800 text-md font-medium">{{ is_array($value) ? json_encode($value) : $value }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="mt-6 space-y-2">
                        <h4 class="flex gap-1 items-center text-lg from-slate-200 via-slate-100 to-white bg-gradient-to-r font-semibold text-slate-500 mt-12 p-2 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Timestamps
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <label class="block text-sm text-slate-500">Registered At</label>
                                <p class="text-slate-800 text-lg font-medium">{{ $registrant->created_at->format('M j, Y g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm text-slate-500">Last Updated</label>
                                <p class="text-slate-800 text-lg font-medium">{{ $registrant->updated_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 p-6 border-t border-slate-200 dark:border-slate-600">
                    <button 
                        wire:click="closeModal" 
                        class="px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 border border-slate-300 dark:border-slate-600 rounded-md hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
