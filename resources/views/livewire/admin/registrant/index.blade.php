<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default w-full overflow-x-scroll">
        @if(count($registrants) > 0)
            <div class="px-4 py-6 md:px-6 xl:px-7.5">
                <input type="search" 
                    wire:model.live.debounce.500ms="search"
                    class="focus:ring-0 lg:w-1/4 w-full rounded-md bg-light border border-slate-300" 
                    placeholder="Search by name, email, or confirmation code" 
                />
            </div>
        @endif
        @if(count($registrants) == 0)
            <div class="flex flex-col justify-center items-center h-full">
                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                    <svg class="size-14 text-slate-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <p class="text-slate-400 text-lg font-medium">No registrants found</p>
                    <p class="text-slate-300 text-sm">Try adjusting your search or filter criteria</p>
                </div>
            </div>
        @else
            <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default sm:px-7.5 xl:pb-1">
                <div class="max-w-full overflow-x-scroll">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-slate-300/50 text-left">
                            <th class="px-4 py-4 font-medium text-black xl:pl-11 cursor-pointer hover:bg-slate-300/60 transition-colors" wire:click="sortByName">
                                Name
                                @if($sortBy === 'firstName')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span class="ml-1 text-gray-400">↓</span>
                                @endif
                            </th>
                            <th class="text-sm px-4 py-4 font-medium text-black cursor-pointer hover:bg-slate-300/60 transition-colors" wire:click="sortByEmail">
                                Contact
                                @if($sortBy === 'email')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span class="ml-1 text-gray-400">↓</span>
                                @endif
                            </th>
                            <th class="text-sm px-4 py-4 font-medium text-black cursor-pointer hover:bg-slate-300/60 transition-colors" wire:click="sortByCreatedAt">
                                Registered
                                @if($sortBy === 'created_at')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span class="ml-1 text-gray-400">↓</span>
                                @endif
                            </th>
                            <th class="text-sm px-4 py-4 font-medium text-black cursor-pointer hover:bg-slate-300/60 transition-colors" wire:click="sortByNetAmount">
                                Amount
                                @if($sortBy === 'netAmount')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span class="ml-1 text-gray-400">↓</span>
                                @endif
                            </th>
                            <th class="text-sm px-4 py-4 font-medium text-black cursor-pointer hover:bg-slate-300/60 transition-colors" wire:click="sortByRegStatus">
                                Reg Status
                                @if($sortBy === 'regStatus')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span class="ml-1 text-gray-400">↓</span>
                                @endif
                            </th>
                            <th class="text-sm px-4 py-4 font-medium text-black cursor-pointer hover:bg-slate-300/60 transition-colors" wire:click="sortByPaymentStatus">
                                Payment Status
                                @if($sortBy === 'paymentStatus')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span class="ml-1 text-gray-400">↓</span>
                                @endif
                            </th>
                            <th class="px-4 py-4 font-medium text-black">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrants as $registrant)
                                <tr wire:key="{{ $registrant->id }}">
                                    <td class="min-w-64 flex gap-2 border-b border-[#eee] px-4 py-5">
                                        <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                            {{ Helper::getInitials($registrant->firstName.' '.$registrant->lastName) }}
                                        </p>
                                        <div>
                                            <h5 class="font-medium text-black">{{$registrant->firstName.' '.$registrant->lastName}}</h5>
                                            <p class="text-[0.7rem] font-thin">
                                                <span class="text-[10px]">Code: </span>
                                                <span>{{$registrant->regCode ?? 'N/A'}}</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        <div class="space-y-1">
                                            <p class="text-black text-sm">
                                                {{ $registrant->email }}
                                            </p>
                                            @if($registrant->contactNumber)
                                                <p class="text-slate-500 text-xs">
                                                    {{ $registrant->contactNumber }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5 min-w-30">
                                        <p class="text-black text-sm">
                                            {{ \Carbon\Carbon::parse($registrant->created_at)->format('M j, Y') }}
                                        </p>
                                        <p class="text-slate-500 text-xs">
                                            {{ \Carbon\Carbon::parse($registrant->created_at)->format('g:i A') }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        <div class="space-y-1">
                                            <p class="text-black text-sm font-medium">
                                                ${{ number_format($registrant->netAmount, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
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
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
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
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-medium {{ $paymentStatusColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $registrant->paymentStatus ?? 'N/A')) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        <div class="flex items-center space-x-3.5 justify-end">
                                            @livewire('admin.registrant.details-slider-view', ['registrant' => $registrant], key($registrant->id))
                                            {{-- @livewire('admin.registrant.payment-slider-view', ['registrant' => $registrant], key($registrant->id)) --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-4">
                        {{ $registrants->links('vendor.livewire.custom-pagination') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
