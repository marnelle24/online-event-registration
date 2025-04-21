@section('title', 'Create Programme')
<x-app-layout>
    <h4 class="text-2xl font-bold text-slate-600 dark:text-slate-600 capitalize mb-2">Add New Programme</h4>
    <p class="mb-8 text-slate-500 italic leading-tight text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minima fugit magnam soluta voluptas neque. Fugit, recusandae. Vero laboriosam quis explicabo sit enim. Sint ipsam necessitatibus quisquam repudiandae inventore tempora perspiciatis.</p>
    <form class="flex flex-col gap-4" action="{{route('admin.programmes.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex gap-4 justify-between">
            <div class="w-3/4 flex flex-col gap-4">
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Title <span class="text-md italic text-red-400">*</span></p>
                        <input 
                            name="title" :value="old('title')"
                            class="placeholder:text-md border border-slate-400 p-2 bg-zinc-50 h-18 focus:outline-none focus:ring-0 shadow-md text-xl placeholder:text-slate-400" type="text" placeholder="Title of the Programme" />
                    </div>
                    <div class="flex gap-4">
                        <div class="flex flex-col w-1/2">
                            <p class="text-md text-slate-500 capitalize mb-1">Program Code <span class="text-md italic text-red-400">*</span></p>
                            <input 
                                name="programmeCode" :value="old('programmeCode')"
                                class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="Programme Code" />
                        </div>
                        <div class="flex flex-col w-1/2">
                            <p class="text-md text-slate-500 capitalize mb-1">Type <span class="text-md italic text-red-400">*</span></p>
                            <select 
                                name="type" :value="old('type')"
                                class="border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400">
                                <option value="" style="color:gray">Select event, course, etc.</option>
                                <option {{ old('type') === 'event' ? 'selected' : '' }} value="event">Event</option>
                                <option {{ old('type') === 'course' ? 'selected' : '' }} value="course">Course</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Description <span class="text-md italic text-red-400">*</span></p>
                        <textarea row="4" class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 flex items-start focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500 placeholder:text-slate-500 placeholder:text-md" placeholder="Full Description"></textarea>
                    </div>
                </div>
                {{-- schedule --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-6">
                    <h4 class="text-2xl font-bold text-slate-600/80">Schedule</h4>
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">
                            Date Schedule 
                            <span class="text-md italic text-red-400">*</span>
                        </p>
                        <div class="flex gap-2 items-center">
                            <input 
                                name="startDate" :value="old('startDate')"
                                class="w-1/4 border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500" type="date" />
                            <span class="text-slate-500 mx-1">-</span>
                            <input 
                                name="endDate" :value="old('endDate')"
                                class="w-1/4 border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500" type="date" />
                            <span class="text-slate-500 mx-1">@</span>
                            <div class="w-1/2 flex items-center justify-evenly">
                                <input 
                                    name="startTime" :value="old('startTime')"
                                    class="w-1/2 border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500" type="time" />
                                <span class="text-slate-500 mx-1">-</span>
                                <input 
                                    name="endTime" :value="old('endTime')"
                                    class="w-1/2 border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500" type="time" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Custom Date <em>(Optional)</em></p>
                        <textarea 
                            name="customDate" :value="old('customDate')"
                            rows="4" class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 h-24 flex items-start focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500 placeholder:text-slate-500 placeholder:text-md" placeholder="Custom Date"></textarea>
                    </div>
                </div>

                {{-- location --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <h4 class="text-2xl font-bold text-slate-600/80">Location</h4>
                    <div class="flex flex-col gap-4">
                        <textarea 
                            name="address" :value="old('address')"
                            rows="2" class="placeholder:text-sm w-full border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" placeholder="Block # / Bldg No / Street Name"></textarea>
                        <div class="flex justify-between gap-2">
                            <input 
                                name="state" :value="old('state')"
                                class="w-full placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="State" />
                            <input 
                                name="city" :value="old('city')"
                                class="w-full placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="City" />
                            <input 
                                name="postalCode" :value="old('postalCode')"
                                class="w-full placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="Postal Code" />
                            <input 
                                name="country" :value="old('country')"
                                class="w-full placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="Country" />
                        </div>
                    </div>
                </div>

                {{-- contact details --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <h4 class="text-2xl font-bold text-slate-600/80">Contact Details</h4>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Email Address 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactEmail" :value="old('contactEmail')"
                                class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="Email Address" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Contact Number 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactNumber" :value="old('contactNumber')"
                                class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="Phone or Mobile Number" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Contact Person 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactPerson" :value="old('contactPerson')"
                                class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 focus:outline-none focus:ring-0 shadow-md text-lg placeholder:text-slate-400" type="text" placeholder="Person In-charge" />
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="w-1/4 flex flex-col gap-4">
                <div class="flex gap-4 justify-center">
                    <button class="w-full px-4 py-3 bg-slate-600 text-white flex place-content-center rounded-lg hover:bg-green-600 duration-300 hover:-translate-y-1">Submit</button>
                    <button type="button" class="w-full px-4 py-3 bg-white font-bold text-slate-700 border border-slate-700 flex place-content-center capitalize hover:bg-slate-300 duration-300 hover:-translate-y-1">Save As Draft</button>
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold mb-4">Categories</h4>
                    <x-category-checkboxes 
                        :categories="$categories" 
                    />
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-sky-100">
                    <x-upload-image class="bg-zinc-200/70 min-h-[150px] border-zinc-400/40" emptyLabel="Thumbnail" name="thumb" />
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-sky-100">
                    <x-upload-image 
                        class="bg-zinc-200/70 min-h-[600px] border-zinc-400/40" 
                        emptyLabel="Upload Poster" 
                        name="a3_poster" 
                    />
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Excerpts <span class="text-md italic text-red-400">*</span></p>
                        <textarea rows="3" 
                            class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 h-24 flex items-start focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500 placeholder:text-slate-500 placeholder:text-md" placeholder="Excerpts (Optional)"></textarea>
                        <em class="text-slate-500 italic pt-2 text-sm">Maximum 200 words</em>
                    </div>
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Excerpts <span class="text-md italic text-red-400">*</span></p>
                        <textarea rows="3" class="placeholder:text-sm border border-slate-400 p-2 bg-zinc-50 h-24 flex items-start focus:outline-none focus:ring-0 shadow-md text-lg text-slate-500 placeholder:text-slate-500 placeholder:text-md" placeholder="Excerpts (Optional)"></textarea>
                        <em class="text-slate-500 italic pt-2 text-sm">Maximum 200 words</em>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout> 

