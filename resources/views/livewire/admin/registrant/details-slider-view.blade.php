<div x-cloak x-data="{ show: false, showToolTip: false }" class="relative">
    <button 
        @click="show = true; $wire.openModal()"
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
            class="absolute top-3 -left-7 mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50"
        >
            Details
        </div>
    </button>

    @if($registrant)
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
        <div class="absolute inset-0 bg-black/50" @click="show = false; $wire.closeModal()"></div>
        
        <!-- Slide-over Modal -->
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute inset-y-0 right-0 lg:w-1/2 w-full bg-white shadow-xl overflow-auto">
            
            <!-- Header -->
            <div class="sticky top-0 z-10 flex justify-between items-center p-4 border-b-2 border-slate-400/70 bg-slate-600">
                <h2 class="text-white text-xl uppercase font-semibold">Registrant Details</h2>
                <button 
                    @click="show = false; $wire.closeModal()" 
                    class="text-white hover:text-gray-200 text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-bold mb-3 text-slate-700">Personal Information</h3>
                    <div class="bg-slate-50 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Confirmation Code</p>
                                <p class="text-sm font-mono font-semibold">{{ $registrant->confirmationCode }}</p>
                            </div>
                            @if($registrant->regCode)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Registration Code</p>
                                <p class="text-sm font-mono font-semibold">{{ $registrant->regCode }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Name</p>
                                <p class="text-sm font-medium">{{ $registrant->title }} {{ $registrant->firstName }} {{ $registrant->lastName }}</p>
                            </div>
                            @if($registrant->nric)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">NRIC</p>
                                <p class="text-sm">{{ $registrant->nric }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Email</p>
                                <p class="text-sm">{{ $registrant->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Contact Number</p>
                                <p class="text-sm">{{ $registrant->contactNumber ?? 'N/A' }}</p>
                            </div>
                            @if($registrant->address || $registrant->city || $registrant->postalCode)
                            <div class="col-span-2">
                                <p class="text-xs text-slate-500 mb-1">Address</p>
                                <p class="text-sm">{{ $registrant->address }}{{ $registrant->city ? ', ' . $registrant->city : '' }}{{ $registrant->postalCode ? ' ' . $registrant->postalCode : '' }}</p>
                            </div>
                            @endif
                            @if($registrant->country)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Country</p>
                                <p class="text-sm">{{ $registrant->country }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Registration Date</p>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($registrant->created_at)->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div>
                    <h3 class="text-lg font-bold mb-3 text-slate-700">Payment Information</h3>
                    <div class="bg-slate-50 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Payment Status</p>
                                @php
                                    $paymentStatusColors = [
                                        'paid' => 'bg-green-100 text-green-800 border-green-600',
                                        'pending' => 'bg-orange-100 text-orange-800 border-orange-600',
                                        'pending_verification' => 'bg-blue-100 text-blue-800 border-blue-600',
                                        'free' => 'bg-yellow-100 text-yellow-800 border-yellow-600',
                                        'unpaid' => 'bg-red-100 text-red-800 border-red-600',
                                        'verified' => 'bg-green-100 text-green-800 border-green-600',
                                    ];
                                    $paymentStatusColor = $paymentStatusColors[$registrant->paymentStatus] ?? 'bg-gray-100 text-gray-800 border-gray-600';
                                @endphp
                                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-medium {{ $paymentStatusColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $registrant->paymentStatus ?? 'N/A')) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Payment Method</p>
                                <p class="text-sm capitalize">{{ str_replace('_', ' ', $registrant->paymentOption ?? 'N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Amount</p>
                                <p class="text-sm font-semibold">${{ number_format($registrant->netAmount, 2) }}</p>
                            </div>
                            @if($registrant->discountAmount > 0)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Discount</p>
                                <p class="text-sm">-${{ number_format($registrant->discountAmount, 2) }}</p>
                            </div>
                            @endif
                            @if($registrant->paymentReferenceNo)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Payment Reference</p>
                                <p class="text-sm font-mono">{{ $registrant->paymentReferenceNo }}</p>
                            </div>
                            @endif
                            @if($registrant->payment_transaction_id)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Transaction ID</p>
                                <p class="text-xs font-mono">{{ $registrant->payment_transaction_id }}</p>
                            </div>
                            @endif
                            @if($registrant->payment_gateway)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Payment Gateway</p>
                                <p class="text-sm capitalize">{{ $registrant->payment_gateway }}</p>
                            </div>
                            @endif
                            @if($registrant->payment_verified_at)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Verified At</p>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($registrant->payment_verified_at)->format('M j, Y g:i A') }}</p>
                            </div>
                            @endif
                            @if($registrant->payment_verified_by)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Verified By</p>
                                <p class="text-sm">{{ $registrant->payment_verified_by }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Registration Status -->
                <div>
                    <h3 class="text-lg font-bold mb-3 text-slate-700">Registration Status</h3>
                    <div class="bg-slate-50 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Status</p>
                                @php
                                    $regStatusColors = [
                                        'unpaid' => 'bg-red-100 text-red-800 border-red-600',
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-600',
                                        'confirmed' => 'bg-green-100 text-green-800 border-green-600',
                                        'cancelled' => 'bg-gray-100 text-gray-800 border-gray-600',
                                    ];
                                    $regStatusColor = $regStatusColors[$registrant->regStatus] ?? 'bg-gray-100 text-gray-800 border-gray-600';
                                @endphp
                                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-medium {{ $regStatusColor }}">
                                    {{ ucfirst($registrant->regStatus ?? 'N/A') }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Registration Type</p>
                                <p class="text-sm capitalize">{{ str_replace('_', ' ', $registrant->registrationType ?? 'N/A') }}</p>
                            </div>
                            @if($registrant->approvedBy)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Approved By</p>
                                <p class="text-sm">{{ $registrant->approvedBy }}</p>
                            </div>
                            @endif
                            @if($registrant->approvedDate)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Approved Date</p>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($registrant->approvedDate)->format('M j, Y') }}</p>
                            </div>
                            @endif
                            @if($registrant->confirmedBy)
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Confirmed By</p>
                                <p class="text-sm">{{ $registrant->confirmedBy }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Promotions & Discounts -->
                @if($registrant->promocode || $registrant->promotion)
                <div>
                    <h3 class="text-lg font-bold mb-3 text-slate-700">Promotions & Discounts</h3>
                    <div class="bg-slate-50 rounded-lg p-4 space-y-2">
                        @if($registrant->promocode)
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Promo Code</p>
                            <p class="text-sm font-medium">{{ $registrant->promocode->code }}</p>
                        </div>
                        @endif
                        @if($registrant->promotion)
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Promotion</p>
                            <p class="text-sm font-medium">{{ $registrant->promotion->name }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Group Members -->
                @if($registrant->groupMembersRelation && $registrant->groupMembersRelation->count() > 0)
                <div>
                    <h3 class="text-lg font-bold mb-3 text-slate-700">Group Members ({{ $registrant->groupMembersRelation->count() }})</h3>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <div class="space-y-2">
                            @foreach($registrant->groupMembersRelation as $member)
                            <div class="border-b border-slate-200 pb-2 last:border-0">
                                <p class="text-sm font-medium">{{ $member->firstName }} {{ $member->lastName }}</p>
                                <p class="text-xs text-slate-500">{{ $member->email }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div>
                    <h3 class="text-lg font-bold mb-3 text-slate-700">Actions</h3>
                    <div class="bg-slate-50 rounded-lg p-4 space-y-3">
                        <!-- Bank Transfer Verification Form -->
                        @if($registrant->paymentOption === 'bank_transfer' && $registrant->paymentStatus === 'pending_verification')
                        <div class="border border-slate-300 rounded-lg p-4 bg-white">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-semibold text-sm">Verify Bank Transfer Payment</h4>
                                <button wire:click="toggleBankTransferForm" class="text-xs text-blue-600 hover:text-blue-800">
                                    {{ $showBankTransferForm ? 'Cancel' : 'Verify Payment' }}
                                </button>
                            </div>
                            @if($showBankTransferForm)
                            <form wire:submit.prevent="verifyPayment" class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Bank Transaction Reference</label>
                                    <input type="text" wire:model="bankTransactionReference" 
                                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter transaction reference from email">
                                    @error('bankTransactionReference') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Verification Notes (Optional)</label>
                                    <textarea wire:model="verificationNotes" rows="3"
                                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Add any notes about the verification"></textarea>
                                    @error('verificationNotes') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">
                                    Verify & Confirm Payment
                                </button>
                            </form>
                            @endif
                        </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 gap-2">
                            @if($registrant->paymentStatus !== 'paid' && $registrant->paymentStatus !== 'free')
                            <button wire:click="confirmPayment" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
                                Confirm Payment
                            </button>
                            @endif

                            <button wire:click="toggleStatusUpdateForm" 
                                class="bg-slate-600 text-white px-4 py-2 rounded-md hover:bg-slate-700 text-sm font-medium">
                                {{ $showStatusUpdateForm ? 'Cancel Update' : 'Update Status' }}
                            </button>

                            @if($registrant->paymentOption === 'hitpay' && $registrant->paymentStatus === 'paid')
                            <button wire:click="processRefund" 
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm font-medium col-span-2">
                                Process Refund
                            </button>
                            @endif
                        </div>

                        <!-- Status Update Form -->
                        @if($showStatusUpdateForm)
                        <div class="border border-slate-300 rounded-lg p-4 bg-white">
                            <h4 class="font-semibold text-sm mb-3">Update Registration & Payment Status</h4>
                            <form wire:submit.prevent="updateStatus" class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Registration Status</label>
                                    <select wire:model="newRegStatus" 
                                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="unpaid">Unpaid</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    @error('newRegStatus') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Payment Status</label>
                                    <select wire:model="newPaymentStatus" 
                                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="unpaid">Unpaid</option>
                                        <option value="free">Free</option>
                                        <option value="pending_verification">Pending Verification</option>
                                        <option value="verified">Verified</option>
                                    </select>
                                    @error('newPaymentStatus') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">
                                    Update Status
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
