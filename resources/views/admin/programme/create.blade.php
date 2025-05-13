@section('title', 'Create Programme')
<x-app-layout>
    <h4 class="text-2xl font-bold text-slate-600 dark:text-slate-600 capitalize mb-2">Add New Programme</h4>
    <p class="mb-8 text-slate-500 italic leading-tight text-sm">
        Start creating programme such as event, course, etc. with customize settings.
    </p>
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 p-4 rounded-md mb-2">
        <x-validation-errors />
    </div>
    @endif

    @php
        $title = 'Testing Event Cebu Expo';
        $programmeCode = '1235BAVF';
        $ministry_id = 7;
        $type = 'event';
        $description = '<h3><strong>Lorem Ipsum Dolor.</strong></h3><p>Lorem Ipsum Dolor. Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.</p><p>&nbsp;</p><ol><li>Lorem Ipsum Dolor.Lorem Ipsum Dolor.</li><li>Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.</li><li>Lorem Ipsum Dolor.Lorem Ipsum Dolor.</li><li>Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.</li><li>Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.</li><li>Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.</li></ol><p>&nbsp;</p><h4><strong>Lorem Ipsum Dolor Lorem Ipsum Dolor.Lorem Ipsum Dolor</strong></h4><p>Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.Lorem Ipsum Dolor.</p><p>&nbsp;</p>';
        $customDate = 'Tuesday in the morning and Wednesday Evening';
        $address = 'Arcenas Street, Sta Ana';
        $city = 'Jakarta';
        $postalcode = 'SG21311';
        $isOnline = true;
        $onlineDetails = 'https://zoom.com/?id=fesfwef34131312';  
        $contactPerson = 'Ms. Joyden Ng';      
        $contactEmail = 'joyden_bss@email.com';      
        $contactNumber = '913-4324-6454';      

        $acd = Carbon\Carbon::create(2025, 12, 10, 23, 30)->format('Y-m-d\TH:i');

        $sd1 = Carbon\Carbon::create(2025, 06, 24, 17, 00);
        $sd = $sd1->format('Y-m-d');
        $sdt = $sd1->format('H:i');

        $ed1 = Carbon\Carbon::create(2025, 06, 25, 20, 00);
        $ed = $ed1->format('Y-m-d');
        $edt = $ed1->format('H:i');
    @endphp
    
    <form class="flex flex-col gap-4" action="{{route('admin.programmes.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex xl:flex-row flex-col gap-4 justify-between">
            <div class="xl:w-3/4 w-full flex flex-col gap-4">
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex lg:flex-row flex-col w-full gap-4 justify-between">
                    <div class="flex flex-col w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Programme Code <span class="text-md italic text-red-400">*</span></p>
                        <div class="flex">
                            <input 
                                name="programmeCode" 
                                value="{{old('programmeCode', $programmeCode)}}" 
                                class="@error('programmeCode') border-red-300 bg-red-100/40 @enderror w-full focus:ring-0 flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                                type="text" 
                                placeholder="Programme Code" 
                            />
                        </div>
                    </div>
                    <div class="flex flex-col lg:w-1/2 w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Ministry <span class="text-md italic text-red-400">*</span></p>
                        <select 
                            name="ministry_id"
                            class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface">
                            <option value="{{old('ministry_id', $ministry_id)}}" style="color:gray">Select Ministry</option>
                            @foreach ($ministries as $key => $value)
                                <option {{ old('ministry_id', $ministry_id) === $key ? 'selected' : '' }} value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col lg:w-1/3 w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Type <span class="text-md italic text-red-400">*</span></p>
                        <select 
                            name="type"
                            class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface">
                            <option value="" style="color:gray">Event/Course</option>
                            <option {{ old('type', $type) === 'event' ? 'selected' : '' }} value="event">Event</option>
                            <option {{ old('type', $type) === 'course' ? 'selected' : '' }} value="course">Course</option>
                        </select>
                    </div>
                </div>
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex gap-4 w-full">
                    <div class="flex flex-col w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Title <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            name="title" 
                            class="focus:border-neutral-400 flex items-center whitespace-nowrap rounded-md border-solid border-neutral-400/70 px-3 py-2 text-md font-normal text-surface border p-2 bg-zinc-50 focus:outline-none focus:ring-0" 
                            placeholder="Title of the Programme">{{old('title', $title)}}</textarea>
                    </div>
                    
                </div>
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Description <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            id="description"
                            rows="6" 
                            name="description"
                            placeholder="Description"
                            class="min-h-[200px] focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface">{{ old('description', $description) }}</textarea>
                    </div>
                </div>
                {{-- schedule --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-6">
                    <h4 class="text-xl font-bold text-slate-600/80">
                        Schedule Details
                        <span class="text-md italic text-red-400">*</span>
                    </h4>
                    <div class="flex lg:flex-row flex-col gap-6 bg-zinc-100 border border-zinc-200/60 p-4">
                        <div class="flex flex-col gap-4 lg:w-1/2 w-full">
                            <p class="text-md text-slate-500">Date & Time</p>
                            <div class="flex lg:flex-row flex-col lg:items-center items-start gap-4 w-full">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span class="lg:hidden flex text-lg ml-1">Date</span>
                                </div>
                                <x-input 
                                    type="date" 
                                    name="startDate" 
                                    value="{{old('startDate', $sd)}}" 
                                    class="w-full rounded-md focus:outline-none focus:ring-0 focus:border-slate-600 bg-zinc-50 border border-solid border-neutral-400/70" 
                                    placeholder="Start Date" 
                                />
                                <div class="lg:flex hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                    </svg>
                                </div>
                                <x-input 
                                    type="date" 
                                    name="endDate" 
                                    value="{{old('endDate', $ed)}}" 
                                    class="w-full rounded-md bg-zinc-50 border border-solid border-neutral-400/70 focus:outline-none focus:ring-0 focus:border-slate-600" 
                                    placeholder="End Date" 
                                />
                            </div>
                            
                            <div class="flex lg:flex-row flex-col lg:items-center items-start gap-4 w-full lg:mt-0 mt-4">
                                <div class="flex items-center">
                                    <svg fill="#000000" height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M276.193,58.507V40.389h14.578c11.153,0,20.194-9.042,20.194-20.194S301.923,0,290.771,0h-69.544 c-11.153,0-20.194,9.042-20.194,20.194s9.042,20.194,20.194,20.194h14.578v18.118C119.952,68.76,28.799,166.327,28.799,284.799 C28.799,410.078,130.721,512,256,512s227.201-101.922,227.201-227.201C483.2,166.327,392.046,68.76,276.193,58.507z M276.193,470.516v-20.124c0-11.153-9.042-20.194-20.194-20.194c-11.153,0-20.194,9.042-20.194,20.194v20.124 c-86.91-9.385-156.137-78.614-165.522-165.522h20.124c11.153,0,20.194-9.042,20.194-20.194s-9.042-20.194-20.194-20.194H70.282 c9.385-86.91,78.614-156.137,165.522-165.523v20.124c0,11.153,9.042,20.194,20.194,20.194c11.153,0,20.194-9.042,20.194-20.194 V99.081c86.91,9.385,156.137,78.614,165.522,165.523h-20.124c-11.153,0-20.194,9.042-20.194,20.194s9.042,20.194,20.194,20.194 h20.126C432.331,391.903,363.103,461.132,276.193,470.516z"></path> <path d="M317.248,194.99l-58.179,58.18c-1.011-0.097-2.034-0.151-3.071-0.151c-17.552,0-31.779,14.229-31.779,31.779 c0,17.552,14.228,31.779,31.779,31.779s31.779-14.229,31.779-31.779c0-1.037-0.054-2.06-0.151-3.07l58.178-58.18 c7.887-7.885,7.887-20.672,0-28.559C337.922,187.103,325.135,187.103,317.248,194.99z"></path> </g> </g> </g> </g></svg>
                                    <span class="lg:hidden flex text-lg ml-1">Time</span>
                                </div>
                                <x-input 
                                    type="time" 
                                    name="startTime" 
                                    value="{{old('startTime', $sdt)}}" 
                                    class="w-full rounded-md bg-zinc-50 border border-solid border-neutral-400/70 focus:outline-none focus:ring-0 focus:border-slate-600" 
                                    placeholder="Start Time" 
                                />
                                <div class="lg:flex hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                    </svg>
                                </div>
                                <x-input 
                                    type="time" 
                                    name="endTime" 
                                    value="{{old('endTime', $edt)}}" 
                                    class="w-full rounded-md bg-zinc-50 border border-solid border-neutral-400/70 focus:outline-none focus:ring-0 focus:border-slate-600" 
                                    placeholder="End Time" 
                                />
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 lg:w-1/2 w-full">
                            <p class="text-md text-slate-500 capitalize">Custom Date <em>(Optional)</em></p>
                            <textarea 
                                name="customDate" 
                                rows="4" 
                                class="focus:border-neutral-400 focus:ring-0 flex items-center rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                                placeholder="Alternative content to display a date in landing page.">{{old('customDate', $customDate)}}</textarea>
                        </div>
                    </div>
                </div>

                {{-- location --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <h4 class="text-xl font-bold text-slate-600/80">Venue & Platform</h4>
                    <div class="flex lg:flex-row flex-col justify-between gap-4 bg-zinc-100 border border-zinc-200/60 p-4">
                        <div class="xl:w-1/2 w-full flex flex-col gap-4">
                            <h4 class="text-md text-slate-600/80 font-bold">Venue Location</h4>
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col">
                                    <p class="mb-1 text-xs text-slate-500 capitalize">Address</p>
                                    <textarea 
                                        name="address"
                                        rows="1" class="focus:border-neutral-400 focus:ring-0 rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                                        placeholder="Bldg No./Street No./Block #">{{old('address', $address)}}</textarea>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <div class="flex flex-col w-full">
                                        <p class="mb-1 text-xs text-slate-500 capitalize">City</p>                                    
                                        <input 
                                            name="city" 
                                            value="{{old('city', $city)}}" 
                                            class="rounded-md focus:border-neutral-400 w-full focus:ring-0 bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="City"
                                        />
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <p class="mb-1 text-xs text-slate-500 capitalize">Postal Code</p>
                                        <input 
                                            name="postalCode" 
                                            value="{{old('postalCode', $postalcode)}}" 
                                            class="rounded-md focus:border-neutral-400 w-full focus:ring-0 bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" 
                                            type="text"
                                            placeholder="Postal Code" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="xl:w-1/2 w-full flex flex-col gap-4">
                            <label class="flex items-center space-x-2">
                                <input 
                                    type="checkbox" 
                                    name="isOnline" 
                                    value="true" 
                                    {{ old('isOnline', $isOnline) ? 'checked' : '' }}
                                    class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0" 
                                />
                                <span>Online and/or Hybrid</span>
                            </label>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="mb-1 text-xs text-slate-500 capitalize">Online Platform Details</p> 
                                <textarea 
                                    name="onlineDetails"
                                    rows="3" class="focus:border-neutral-400 focus:ring-0 rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                                    placeholder="Online platform url (Zoom, Google Meet, Whatsapp, etc.)">{{old('onlineLink', $onlineDetails)}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- contact details --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div>
                        <h4 class="text-2xl font-bold text-slate-600/80">Contact Details</h4>
                        <p class="text-sm text-slate-500 mb-2 italic leading-snug">Fill out the programme contact details where the participants can inquire for more details.</p>
                    </div>
                    <div class="flex flex-col justify-between gap-4">
                        <div class="flex flex-col w-full gap-1">
                            <div class="flex gap-2 items-center">
                                <svg height="20px" width="20px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> <g> <path class="st0" d="M464.496,431.904c-13.636-24.598-34.497-41.724-54.571-53.835c-20.086-12.104-39.685-19.308-51.156-23.611 c-8.74-3.246-17.968-7.456-24.307-11.92c-3.174-2.204-5.578-4.463-6.91-6.3c-1.363-1.883-1.635-3.04-1.646-3.958 c0-8.743,0-19.675,0-34.305c1.263-3.193,2.584-5.796,4.076-8.215c2.527-4.15,5.892-8.344,9.268-14.653 c2.802-5.26,5.302-11.882,7.235-20.548c1.7-0.827,3.395-1.784,5.048-2.94c5.068-3.499,9.356-8.598,12.862-15.266 c3.545-6.699,6.604-15.098,9.865-26.474l-0.027,0.076l0.027-0.084c1.677-5.902,2.481-11.086,2.484-15.802 c0.058-7.579-2.312-14.148-6.232-18.582c-1.366-1.569-2.844-2.756-4.329-3.782c0.494-5.834,1.385-13.574,2.231-22.5 c0.98-10.358,1.864-22.202,1.864-34.467c-0.038-19.408-2.105-39.902-10.316-57.587c-4.115-8.82-9.887-16.934-17.769-23.342 c-7.262-5.918-16.33-10.16-26.849-12.395c-7.139-5.474-14.052-10.266-22.669-13.597c-9.302-3.605-20.039-5.274-34.222-5.266 c-4.475,0-9.317,0.16-14.615,0.482C229.032,3.1,216.909,4.9,205.203,4.869c-8.165-0.008-16.223-0.789-25.559-3.446L174.642,0 l-3.985,3.338c-12.261,10.412-18.842,25.93-22.868,43.171c-3.978,17.318-5.267,36.786-5.279,56.087 c0.004,25.188,2.255,50.069,4.169,68.742c-1.459,0.949-2.909,2.044-4.284,3.506c-4.226,4.426-6.875,11.27-6.802,19.209 c0.004,4.708,0.808,9.891,2.484,15.786l0.008,0.031c4.356,15.158,8.295,25.088,13.624,32.621c2.656,3.744,5.742,6.806,9.095,9.126 c1.646,1.148,3.33,2.098,5.022,2.924c3.035,12.969,8.146,22.37,12.529,29.176c2.465,3.851,4.643,6.913,5.99,9.202 c1.29,2.144,1.673,3.369,1.75,3.928c0,15.228,0,26.451,0,35.431c0.004,0.713-0.276,1.968-1.792,3.982 c-2.197,2.978-6.99,6.775-12.735,9.991c-5.735,3.269-12.361,6.102-18.16,8.146c-15.614,5.528-45.239,16.315-71.468,37.315 c-13.114,10.511-25.425,23.665-34.478,40.094C38.405,448.22,32.72,467.91,32.74,490.794c0,3.973,0.169,8.054,0.517,12.226 l0.75,8.98h443.986l0.75-8.98c0.348-4.164,0.517-8.23,0.517-12.203C479.279,467.941,473.579,448.28,464.496,431.904z M459.592,492.401H52.408c-0.008-0.528-0.069-1.087-0.069-1.607c0.015-19.684,4.754-35.814,12.291-49.534 c11.289-20.533,29.242-35.692,47.474-46.686c18.217-10.994,36.453-17.692,47.818-21.696c8.954-3.169,19.354-7.756,28.212-13.903 c4.429-3.093,8.506-6.577,11.782-10.871c3.235-4.241,5.773-9.623,5.776-15.825c0-9.149,0-20.579,0-36.258v-0.505l-0.054-0.506 c-0.532-4.9-2.48-8.766-4.444-12.096c-3.013-5.023-6.4-9.394-9.497-15.059c-3.085-5.643-5.96-12.456-7.667-22.049l-0.992-5.604 l-5.359-1.914c-2.45-0.88-4.203-1.73-5.681-2.756c-2.174-1.546-4.187-3.613-6.744-8.368c-2.519-4.723-5.286-11.996-8.322-22.669 v-0.007c-1.305-4.548-1.742-7.993-1.742-10.435c0.077-4.196,1.01-5.183,1.516-5.819c0.543-0.612,1.512-1.079,2.587-1.317 l8.521-1.906l-0.915-8.682c-2.01-19.048-4.792-46.532-4.792-73.734c-0.008-18.382,1.297-36.626,4.777-51.685 c2.887-12.717,7.415-22.822,13.05-29.253c9.053,2.066,17.436,2.817,25.268,2.81c13.815-0.03,25.881-1.884,39.167-1.853h0.314 l0.333-0.015c4.98-0.306,9.436-0.452,13.436-0.452c12.754,0.007,20.705,1.462,27.159,3.95c6.446,2.488,11.966,6.278,19.43,12.089 l1.922,1.492l2.392,0.421c8.754,1.569,15.239,4.686,20.472,8.919c7.798,6.323,13.049,15.656,16.361,27.232 c3.3,11.53,4.501,25.05,4.49,38.486c0.004,11.316-0.822,22.569-1.776,32.622c-0.953,10.067-2.025,18.848-2.504,25.708h0.004 c-0.088,1.218-0.195,2.266-0.318,3.446l-0.869,8.352l8.119,2.136c1.037,0.275,1.856,0.72,2.377,1.332 c0.486,0.636,1.37,1.738,1.432,5.735c0,2.434-0.436,5.872-1.726,10.396l-0.008,0.024c-4.038,14.255-7.655,22.385-10.729,26.619 c-1.543,2.136-2.867,3.384-4.345,4.425c-1.478,1.026-3.231,1.876-5.68,2.756l-5.359,1.914l-0.992,5.604 c-1.168,6.606-2.572,11.369-4.054,15.105c-2.236,5.589-4.636,9.049-7.729,13.62c-3.062,4.509-6.752,10.121-9.635,18.168 l-0.582,1.608v1.714c0,15.679,0,27.109,0,36.258c-0.011,5.987,2.328,11.354,5.459,15.573c4.75,6.376,11.242,10.986,18.259,15.013 c7.032,3.989,14.684,7.258,21.876,9.952c15.212,5.658,42.64,15.902,65.836,34.444c11.592,9.256,22.06,20.487,29.613,34.137 c7.545,13.673,12.295,29.751,12.31,49.419C459.661,491.329,459.6,491.88,459.592,492.401z"></path> </g> </g></svg>
                                <div class="w-full">
                                    <p class="mb-1 text-xs text-slate-500 capitalize">Person In-charge</p>
                                    <input 
                                        name="contactPerson" value="{{old('contactPerson', $contactPerson)}}"
                                        class="focus:border-neutral-400 focus:ring-0 w-full flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Contact Person" />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col w-full gap-1">
                            <div class="flex gap-2 items-center">
                                <svg height="20px" width="20px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> <g> <path class="st0" d="M510.746,110.361c-2.128-10.754-6.926-20.918-13.926-29.463c-1.422-1.794-2.909-3.39-4.535-5.009 c-12.454-12.52-29.778-19.701-47.531-19.701H67.244c-17.951,0-34.834,7-47.539,19.708c-1.608,1.604-3.099,3.216-4.575,5.067 c-6.97,8.509-11.747,18.659-13.824,29.428C0.438,114.62,0,119.002,0,123.435v265.137c0,9.224,1.874,18.206,5.589,26.745 c3.215,7.583,8.093,14.772,14.112,20.788c1.516,1.509,3.022,2.901,4.63,4.258c12.034,9.966,27.272,15.45,42.913,15.45h377.51 c15.742,0,30.965-5.505,42.967-15.56c1.604-1.298,3.091-2.661,4.578-4.148c5.818-5.812,10.442-12.49,13.766-19.854l0.438-1.05 c3.646-8.377,5.497-17.33,5.497-26.628V123.435C512,119.06,511.578,114.649,510.746,110.361z M34.823,99.104 c0.951-1.392,2.165-2.821,3.714-4.382c7.689-7.685,17.886-11.914,28.706-11.914h377.51c10.915,0,21.115,4.236,28.719,11.929 c1.313,1.327,2.567,2.8,3.661,4.272l2.887,3.88l-201.5,175.616c-6.212,5.446-14.21,8.443-22.523,8.443 c-8.231,0-16.222-2.99-22.508-8.436L32.19,102.939L34.823,99.104z M26.755,390.913c-0.109-0.722-0.134-1.524-0.134-2.341V128.925 l156.37,136.411L28.199,400.297L26.755,390.913z M464.899,423.84c-6.052,3.492-13.022,5.344-20.145,5.344H67.244 c-7.127,0-14.094-1.852-20.142-5.344l-6.328-3.668l159.936-139.379l17.528,15.246c10.514,9.128,23.922,14.16,37.761,14.16 c13.89,0,27.32-5.032,37.827-14.16l17.521-15.253L471.228,420.18L464.899,423.84z M485.372,388.572 c0,0.803-0.015,1.597-0.116,2.304l-1.386,9.472L329.012,265.409l156.36-136.418V388.572z"></path> </g> </g></svg>
                                <div class="w-full">
                                    <p class="mb-1 text-xs text-slate-500 capitalize">Contact Email</p>
                                    <input 
                                        name="contactEmail" value="{{old('contactEmail', $contactEmail)}}"
                                        class="focus:border-neutral-400 focus:ring-0 w-full flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Email Address" />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col w-full gap-1">
                            <div class="flex gap-2 items-center">
                                <svg height="20px" width="25px" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 523.156 523.155" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M342.859,0H180.296c-31.681,0-57.375,25.695-57.375,57.375V465.78c0,31.681,25.694,57.375,57.375,57.375h162.562 c31.681,0,57.375-25.694,57.375-57.375V57.375C400.234,25.695,374.549,0,342.859,0z M316.658,29.883 c2.151,0,3.883,1.741,3.883,3.883c0,2.151-1.741,3.882-3.883,3.882c-2.151,0-3.883-1.741-3.883-3.882 C312.775,31.624,314.516,29.883,316.658,29.883z M316.658,42.735c2.151,0,3.883,1.741,3.883,3.882 c0,2.142-1.741,3.883-3.883,3.883c-2.151,0-3.883-1.741-3.883-3.883C312.775,44.476,314.516,42.735,316.658,42.735z M221.033,37.523h81.712c2.888,0,5.221,2.333,5.221,5.211c0,2.888-2.333,5.221-5.221,5.221h-81.712 c-2.888,0-5.221-2.333-5.221-5.221C215.812,39.856,218.145,37.523,221.033,37.523z M283.887,467.77 c0,10.557-8.568,19.125-19.125,19.125h-7.172c-10.558,0-19.125-8.568-19.125-19.125v-7.966c0-10.558,8.567-19.125,19.125-19.125 h7.172c10.557,0,19.125,8.567,19.125,19.125V467.77z M372.34,415.969H145.231V112.359H372.34V415.969z"></path> <circle cx="228.616" cy="42.735" r="1.607"></circle> <circle cx="233.311" cy="42.735" r="1.607"></circle> <circle cx="238.006" cy="42.735" r="1.607"></circle> <circle cx="242.692" cy="42.735" r="1.607"></circle> <circle cx="247.387" cy="42.735" r="1.607"></circle> <circle cx="252.073" cy="42.735" r="1.607"></circle> <circle cx="256.758" cy="42.735" r="1.607"></circle> <circle cx="261.454" cy="42.735" r="1.607"></circle> <circle cx="266.139" cy="42.735" r="1.607"></circle> <circle cx="270.843" cy="42.735" r="1.607"></circle> <circle cx="275.53" cy="42.735" r="1.607"></circle> <circle cx="280.224" cy="42.735" r="1.607"></circle> <circle cx="284.911" cy="42.735" r="1.607"></circle> <circle cx="289.605" cy="42.735" r="1.607"></circle> </g> </g> </g></svg>
                                <div class="w-full">
                                    <p class="mb-1 text-xs text-slate-500 capitalize">Contact Number</p>
                                    <input 
                                        name="contactNumber" value="{{old('contactNumber', $contactNumber)}}"
                                        class="focus:border-neutral-400 focus:ring-0 w-full flex items-center whitespace-nowrap rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Contact Number" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="xl:w-1/4 w-full flex flex-col gap-4">
                <div class="xl:flex hidden gap-4 justify-center">
                    <button 
                        type="submit"
                        name="status"
                        value="published"
                        class="w-full px-4 py-3 bg-slate-600 text-white flex place-content-center rounded-none hover:bg-slate-500 duration-300 hover:-translate-y-1">Submit</button>
                    <button 
                        type="submit"
                        name="status"
                        value="draft"
                        class="w-full px-4 py-3 bg-slate-300 font-bold text-slate-700 border border-slate-700 flex place-content-center capitalize hover:bg-slate-100 duration-300 hover:-translate-y-1">Save As Draft</button>
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Excerpt <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            rows="3" 
                            placeholder="Excerpt"
                            name="excerpt"
                            value="{{old('excerpt')}}"
                            class="min-h-[100px] focus:border-neutral-400 focus:ring-0 flex items-center rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface">{{old('excerpt', 'This is the test excerpt for this programme')}}</textarea>
                        <em class="text-slate-500 italic pt-2 text-sm">Maximum of 300 characters</em>
                    </div>
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <p class="text-lg text-slate-700 capitalize font-bold mb-1">Price <span class="text-md italic text-red-400">*</span></p>
                    <div class="relative mb-4 flex flex-wrap items-stretch">
                        <span
                            class="flex items-center whitespace-nowrap rounded-l-md bg-zinc-100 border border-solid border-neutral-400/70 px-3 py-2 text-center text-base font-normal text-surface"
                            id="basic-addon1"
                            >SGD$</span
                        >
                        <input
                            type="text"
                            name="price"
                            value="{{old('price', 100)}}"
                            class="relative m-0 block flex-auto rounded-r-md bg-zinc-50 border border-l-0 border-solid border-neutral-400/70 focus:ring-0 bg-clip-padding px-3 py-2 text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-neutral-400 focus:shadow-inset focus:outline-none motion-reduce:transition-none"
                            placeholder="Price"
                            aria-label="price"
                            aria-describedby="basic-addon1" />
                    </div>
                    <p class="text-lg text-slate-700 capitalize font-bold">Admin Fee 
                    </p>
                    <p class="text-sm text-slate-500 italic leading-snug">Add service or admin fee.</p>
                    <p class="text-sm text-slate-500 mb-2 italic leading-snug">This will be added during checkout</p>
                    <div class="relative mb-4 flex flex-wrap items-stretch">
                    <span
                        class="flex items-center whitespace-nowrap rounded-l-md bg-zinc-100 border border-solid border-neutral-400/70 px-3 py-2 text-center text-base font-normal text-surface"
                        id="basic-addon1"
                        >SGD$</span
                    >
                    <input
                        type="text"
                        name="adminFee"
                        value="{{old('adminFee', 10)}}"
                        class="relative m-0 block flex-auto rounded-r-md bg-zinc-50 border border-l-0 border-solid border-neutral-400/70 focus:ring-0 bg-clip-padding px-3 py-2 text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-neutral-400 focus:shadow-inset focus:outline-none motion-reduce:transition-none"
                        placeholder="Admin Fee"
                        aria-label="admin_fee"
                        aria-describedby="basic-addon1" />
                    </div>
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold">External Link <em class="text-sm">(Optional)</em></h4>
                    <p class="text-sm text-slate-500 mb-2 italic leading-snug">If programme has 3rd party registration link</p>
                    <input 
                        class="focus:border-neutral-400 placeholder:italic w-full focus:ring-0 rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                        name="externalUrl" 
                        value="{{old('externalUrl', 'https://telegram.com?id=fesfs4e234234v32423432')}}" 
                        type="text" 
                        placeholder="www.external.url" 
                    />
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold mb-4">Status</h4>
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="private_only" value="1" {{ old('private_only', '0') ? 'checked' : '' }} class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                        <span>Private Only</span>
                    </label>
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="searchable" value="1" {{ old('searchable', '1') ? 'checked' : '' }}  class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                        <span>Searchable</span>
                    </label>
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="publishable" value="1" {{ old('publishable', '1') ? 'checked' : '' }} class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                        <span>Publishable</span>
                    </label>
                    <br />
                    <div>
                        <h4 class="text-xl text-slate-600 capitalize font-bold">Participants Limit <em class="text-sm">(Optional)</em></h4>
                        <p class="text-sm text-slate-500 italic leading-snug">Set a maximum registration</p>
                        <p class="text-sm text-slate-500 mb-2 italic leading-snug">Set 0 for unlimited participants</p>
                        <input 
                            class="focus:border-neutral-400 xl:w-1/2 w-full focus:ring-0 rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                            name="limit" 
                            value="{{old('limit', 99)}}" 
                            type="number" 
                            placeholder="0" 
                        />
                    </div>
                    <div class="mt-4">
                        <h4 class="text-xl text-slate-600 capitalize font-bold">Active Registration <em class="text-sm">(Optional)</em></h4>
                        <p class="text-sm text-slate-500 italic leading-snug my-1">Accept registration until the specified date</p>
                        <input 
                            class="focus:border-neutral-400 w-full focus:ring-0 rounded-md bg-zinc-50 border border-solid border-neutral-400/70 px-3 py-2 text-base font-normal text-surface" 
                            name="activeUntil" 
                            value="{{old('activeUntil', $acd)}}" 
                            type="datetime-local" 
                        />
                    </div>
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold">Categories</h4>
                    <p class="text-sm text-slate-500 italic leading-snug my-1">Scroll to view more categories</p>
                    <div class="space-y-2 max-h-48 overflow-y-auto mt-4">
                        @foreach ($categories as $key => $value)
                            <label class="flex items-center gap-2 my-1">
                                <input 
                                    class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0"
                                    type="checkbox" 
                                    name="categories[]" 
                                    value="{{ $key }}"
                                    {{ in_array($key, old('categories', [])) ? 'checked' : '' }}>
                                {{ $value }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="@error('thumb') border-red-600 @enderror shadow-md p-4 border border-slate-400/70 rounded-none bg-white">
                    <x-upload-image class="bg-zinc-200/70 min-h-[150px] border-zinc-400/40" emptyLabel="Thumbnail" name="thumb" />
                </div>
                <div class="@error('a3_poster') border-red-600 @enderror shadow-md p-4 border border-slate-400/70 rounded-none bg-white">
                    <x-upload-image 
                        class="bg-zinc-200/70 min-h-[250px] border-zinc-400/40" 
                        emptyLabel="Upload Poster" 
                        name="a3_poster" 
                    />
                </div>

                <div class="xl:hidden flex gap-4 justify-center">
                    <button 
                        type="submit"
                        name="status"
                        value="published"
                        class="w-full px-4 py-3 bg-slate-600 text-white flex place-content-center rounded-none hover:bg-slate-500 duration-300 hover:-translate-y-0.5">Submit</button>
                    <button 
                        type="submit"
                        name="status"
                        value="draft" 
                        class="w-full px-4 py-3 bg-slate-300 font-bold text-slate-700 border border-slate-700 flex place-content-center capitalize hover:bg-slate-100 duration-300 hover:-translate-y-0.5">Save As Draft</button>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        
        <script>
            ClassicEditor
                .create(document.querySelector('#description'), {
                    removePlugins: ['ImageUpload', 'EasyImage', 'CKFinder', 'CKFinderUploadAdapter', 'Base64UploadAdapter'],
                    toolbar: [
                        'heading', '|',
                        'undo', 'redo', '|',
                        'bold', 'italic', 'link',
                        'bulletedList', 'numberedList', '|'
                    ],
                    
                    
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
    <style>
        .ck-content {
            min-height:300px;
            background-color: #fafafa !important;
        }
        .ck-content a {
            color:#3989f1 !important;
            text-decoration: underline !important;
        }
        .ck-content ol, .ck-content ul {
            padding-inline: 30px !important;
        }

        .ck-content h2 {
            font-size: 40px !important;
        } 
        .ck-content h3 {
            font-size: 30px !important;
        }
        .ck-content h4 {
            font-size: 20px !important;
        }
    </style>
</x-app-layout> 

