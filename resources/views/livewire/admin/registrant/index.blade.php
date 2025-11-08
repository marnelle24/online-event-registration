<div class="w-full">
    <div class="rounded-sm border border-stroke bg-white shadow-default w-full overflow-x-scroll">
        @if(count($registrants) > 0)
            <div class="px-4 py-6 md:px-6 xl:px-7.5">
                <input type="search" 
                    wire:model.live.debounce.500ms="search"
                    class="focus:ring-0 lg:w-1/4 w-full rounded-md bg-light border border-slate-300 rounded-r-none" 
                    placeholder="Search by name or email" 
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
                <div class="max-w-full">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-2 text-left">
                            <th class="min-w-[220px] px-4 py-4 font-medium text-black xl:pl-11">
                                Name
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black">
                                Email
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black">
                                Date Registered
                            </th>
                            <th class="min-w-[120px] px-4 py-4 font-medium text-black">
                                Status
                            </th>
                            <th class="px-4 py-4 font-medium text-black">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrants as $registrant)
                                <tr wire:key="{{ $registrant->id }}">
                                    <td class="flex gap-2 border-b border-[#eee] px-4 py-5 pl-9 xl:pl-11">
                                        <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                            {{ Helper::getInitials($registrant->firstName.' '.$registrant->lastName) }}
                                        </p>
                                        <div>
                                            <h5 class="font-medium text-black">{{$registrant->firstName.' '.$registrant->lastName}}</h5>
                                            <p class="text-[0.7rem] font-mono font-thin"><span>Confirmation Code: </span>{{$registrant->confirmationCode}}</p>
                                        </div>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        <p class="text-black text-sm">
                                            {{ $registrant->email }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        <p class="text-black text-sm">
                                            {{ \Carbon\Carbon::parse($registrant->created_at)->format('M j, Y') }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        @if ($registrant->regStatus == 'unpaid')
                                            <p class="inline-flex rounded-full bg-danger px-3 py-1 text-sm font-medium text-danger">Unpaid</p>
                                        @elseif ($registrant->regStatus == 'pending')
                                            <p class="inline-flex rounded-full bg-warning px-3 py-1 text-sm font-medium text-warning">Pending</p>
                                        @else
                                            <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Paid</p>
                                        @endif
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5">
                                        <div class="flex items-center space-x-3.5 justify-end">
                                            @livewire('admin.registrant.details-slider-view', ['registrant' => $registrant], key($registrant->id))
                                            @livewire('admin.registrant.payment-slider-view', ['registrant' => $registrant], key($registrant->id))
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
