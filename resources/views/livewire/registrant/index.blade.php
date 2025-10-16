<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default w-full overflow-x-scroll">
        <div class="px-4 py-6 md:px-6 xl:px-7.5">
            <input type="search" 
                wire:model.live.debounce.500ms="search"
                class="focus:ring-0 lg:w-1/4 w-full rounded-md bg-light border border-slate-300 rounded-r-none" 
                placeholder="Search by name or email" 
            />
        </div>
        @if(count($registrants) == 0)
            <div class="flex flex-col gap-4 justify-center items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <p class="text-center italic text-slate-500">
                    No registrants found
                </p>
            </div>
        @else
            <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                <div class="max-w-full">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                Name
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                Email
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                Date Registered
                            </th>
                            <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                                Status
                            </th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrants as $registrant)
                                <tr wire:key="{{ $registrant->id }}">
                                    <td class="flex gap-2 border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                        <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                            {{ Helper::getInitials($registrant->firstName.' '.$registrant->lastName) }}
                                        </p>
                                        <div>
                                            <h5 class="font-medium text-black dark:text-white">{{$registrant->firstName.' '.$registrant->lastName}}</h5>
                                            <p class="text-[0.7rem] font-mono font-thin"><span>Confirmation Code: </span>{{$registrant->confirmationCode}}</p>
                                        </div>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                        <p class="text-black dark:text-white text-sm">
                                            {{ $registrant->email }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                        <p class="text-black dark:text-white text-sm">
                                            {{ \Carbon\Carbon::parse($registrant->created_at)->format('M j, Y') }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                        @if ($registrant->regStatus == 'unpaid')
                                            <p class="inline-flex rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Unpaid</p>
                                        @elseif ($registrant->regStatus == 'pending')
                                            <p class="inline-flex rounded-full bg-warning bg-opacity-10 px-3 py-1 text-sm font-medium text-warning">Pending</p>
                                        @else
                                            <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Paid</p>
                                        @endif
                                    </td>
                                    <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                        <div class="flex items-center space-x-3.5 justify-end">
                                            @livewire('registrant.details-slider-view', ['registrant' => $registrant], key($registrant->id))
                                            @livewire('registrant.payment-slider-view', ['registrant' => $registrant], key($registrant->id))
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
