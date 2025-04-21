@section('title', 'Create Programme')
<x-app-layout>
    <h4 class="text-2xl font-bold text-slate-600 dark:text-slate-600 capitalize mb-2">Add New Programme</h4>
    <p class="mb-8 text-slate-500 italic leading-tight text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minima fugit magnam soluta voluptas neque. Fugit, recusandae. Vero laboriosam quis explicabo sit enim. Sint ipsam necessitatibus quisquam repudiandae inventore tempora perspiciatis.</p>
    <form class="flex flex-col gap-4" action="{{route('admin.programmes.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex xl:flex-row flex-col gap-4 justify-between">
            <div class="xl:w-3/4 w-full flex flex-col gap-4">
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Title <span class="text-md italic text-red-400">*</span></p>
                        <input 
                            name="title" :value="old('title')"
                            class="focus:border-neutral-400 flex items-center whitespace-nowrap rounded-none border-solid border-neutral-400 px-3 py-2 text-xl font-normal text-surface placeholder:text-md border p-2 bg-zinc-50 h-18 focus:outline-none focus:ring-0" type="text" placeholder="Title of the Programme" />
                    </div>
                    <div class="flex gap-4">
                        <div class="flex flex-col w-1/2">
                            <p class="text-md text-slate-500 capitalize mb-1">Program Code <span class="text-md italic text-red-400">*</span></p>
                            <input 
                                name="programmeCode" :value="old('programmeCode')"
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Programme Code" />
                        </div>
                        <div class="flex flex-col w-1/2">
                            <p class="text-md text-slate-500 capitalize mb-1">Type <span class="text-md italic text-red-400">*</span></p>
                            <select 
                                name="type" :value="old('type')"
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface">
                                <option value="" style="color:gray">Select event, course, etc.</option>
                                <option {{ old('type') === 'event' ? 'selected' : '' }} value="event">Event</option>
                                <option {{ old('type') === 'course' ? 'selected' : '' }} value="course">Course</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Excerpt <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            rows="3" 
                            placeholder="Excerpt"
                            name="excerpt"
                            :value="old('excerpt')"
                            class="min-h-[100px] focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface"></textarea>
                        <em class="text-slate-500 italic pt-2 text-sm">Maximum of 100 words</em>
                    </div>
                </div>
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Description <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            rows="6" 
                            name="description"
                            placeholder="Description"
                            :value="old('description')"
                            class="min-h-[150px] focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface"></textarea>
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
                        <div class="flex xl:flex-row flex-col gap-2 items-center">
                            <input 
                                name="startDate" :value="old('startDate')"
                                class="xl:w-1/4 w-full focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="date" />
                            <span class="text-slate-500 mx-1 xl:flex hidden">-</span>
                            <input 
                                name="endDate" :value="old('endDate')"
                                class="xl:w-1/4 w-full focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="date" />
                            <span class="text-slate-500 mx-1 xl:flex hidden">@</span>
                            <div class="xl:w-1/2 w-full flex items-center justify-evenly">
                                <input 
                                    name="startTime" :value="old('startTime')"
                                    class="w-1/2 focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="time" />
                                <span class="text-slate-500 mx-1">-</span>
                                <input 
                                    name="endTime" :value="old('endTime')"
                                    class="w-1/2 focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="time" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Custom Date <em>(Optional)</em></p>
                        <textarea 
                            name="customDate" :value="old('customDate')"
                            rows="4" 
                            class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" placeholder="Custom Date"></textarea>
                    </div>
                </div>

                {{-- location --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <h4 class="text-2xl font-bold text-slate-600/80">Location</h4>
                    <div class="flex flex-col gap-4">
                        <textarea 
                            name="address" :value="old('address')"
                            rows="2" class="focus:border-neutral-400 focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" placeholder="Block # / Bldg No / Street Name"></textarea>
                        <div class="flex xl:flex-row flex-col justify-between gap-2">
                            <input 
                                name="state" :value="old('state')"
                                class="focus:border-neutral-400 w-full focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="State" />
                            <input 
                                name="city" :value="old('city')"
                                class="focus:border-neutral-400 w-full focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="City" />
                            <input 
                                name="postalCode" :value="old('postalCode')"
                                class="focus:border-neutral-400 w-full focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Postal Code" />
                            <input 
                                name="country" :value="old('country')"
                                class="focus:border-neutral-400 w-full focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Country" />
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
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Email Address" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Contact Number 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactNumber" :value="old('contactNumber')"
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Phone or Mobile Number" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Contact Person 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactPerson" :value="old('contactPerson')"
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Person In-charge" />
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="xl:w-1/4 w-full flex flex-col gap-4">
                <div class="flex gap-4 justify-center">
                    <button class="w-full px-4 py-3 bg-slate-600 text-white flex place-content-center rounded-none hover:bg-slate-500 duration-300 hover:-translate-y-1">Submit</button>
                    <button type="button" class="w-full px-4 py-3 bg-slate-300 font-bold text-slate-700 border border-slate-700 flex place-content-center capitalize hover:bg-slate-100 duration-300 hover:-translate-y-1">Save As Draft</button>
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <p class="text-md text-slate-500 capitalize mb-1">Price <span class="text-md italic text-red-400">*</span></p>
                    <div class="relative mb-4 flex flex-wrap items-stretch">
                    <span
                        class="flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-e-0 border-solid border-neutral-400 px-3 py-2 text-center text-base font-normal text-surface"
                        id="basic-addon1"
                        >SGD$</span
                    >
                    <input
                        type="text"
                        class="relative m-0 block flex-auto rounded-none border border-solid border-neutral-400 bg-zinc-50 focus:ring-0 bg-clip-padding px-3 py-2 text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-neutral-400 focus:shadow-inset focus:outline-none motion-reduce:transition-none"
                        placeholder="Price"
                        aria-label="price"
                        aria-describedby="basic-addon1" />
                    </div>
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
            </div>
        </div>
    </form>
</x-app-layout> 

