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
                                value="{{old('programmeCode')}}" 
                                class="focus:border-neutral-700 border-r-0 w-full focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" 
                                type="text" 
                                placeholder="Programme Code" 
                            />
                            <button type="button" class="flex gap-2 whitespace-nowrap justify-center items-center bg-neutral-200 hover:bg-neutral-300 duration-300 border border-neutral-400 px-3 py-2 text-base font-normal text-surface">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                <span class="text-sm">Generate</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col lg:w-1/2 w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Ministry <span class="text-md italic text-red-400">*</span></p>
                        <select 
                            name="ministry_id"
                            class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface">
                            <option value="" style="color:gray">Select Ministry</option>
                            @foreach ($ministries as $key => $value)
                                <option {{ old('ministry_id') === $key ? 'selected' : '' }} value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col lg:w-1/3 w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Type <span class="text-md italic text-red-400">*</span></p>
                        <select 
                            name="type"
                            class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface">
                            <option value="" style="color:gray">Event/Course</option>
                            <option {{ old('type') === 'event' ? 'selected' : '' }} value="event">Event</option>
                            <option {{ old('type') === 'course' ? 'selected' : '' }} value="course">Course</option>
                        </select>
                    </div>
                </div>
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex gap-4 w-full">
                    <div class="flex flex-col w-full">
                        <p class="text-md text-slate-500 capitalize mb-1">Title <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            name="title" 
                            value="{{old('title')}}"
                            class="focus:border-neutral-400 flex items-center whitespace-nowrap rounded-none border-solid border-neutral-400 px-3 py-2 text-md font-normal text-surface border p-2 bg-zinc-50 focus:outline-none focus:ring-0" 
                            placeholder="Title of the Programme"></textarea>
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
                            class="min-h-[200px] focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface">{{ old('description', '') }}</textarea>
                    </div>
                </div>
                {{-- schedule --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-6">
                    <h4 class="text-xl font-bold text-slate-600/80">Schedule</h4>
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">
                            Date Schedule 
                            <span class="text-md italic text-red-400">*</span>
                        </p>
                        <div class="flex xl:flex-row flex-col gap-2 items-center">
                            <input 
                                name="startDate" value="{{old('startDate')}}"
                                class="xl:w-1/4 w-full focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="date" />
                            <span class="text-slate-500 mx-1 xl:flex hidden">-</span>
                            <input 
                                name="endDate" value="{{old('endDate')}}"
                                class="xl:w-1/4 w-full focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="date" />
                            <span class="text-slate-500 mx-1 xl:flex hidden">@</span>
                            <div class="xl:w-1/2 w-full flex items-center justify-evenly">
                                <input 
                                    name="startTime" value="{{old('startTime')}}"
                                    class="w-1/2 focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="time" />
                                <span class="text-slate-500 mx-1">-</span>
                                <input 
                                    name="endTime" value="{{old('endTime')}}"
                                    class="w-1/2 focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="time" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Custom Date <em>(Optional)</em></p>
                        <textarea 
                            name="customDate" value="{{old('customDate')}}"
                            rows="1" 
                            class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" placeholder="Custom Date"></textarea>
                    </div>
                </div>

                {{-- location --}}
                <div class="shadow-md p-6 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <h4 class="text-xl font-bold text-slate-600/80">Venue & Platform</h4>
                    <div class="flex justify-between gap-4">
                        <div class="xl:w-1/2 w-full flex flex-col gap-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="online" value="{{old('online')}}" class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                                <span>Online Event</span>
                            </label>
                            <textarea 
                                name="onlineLink" value="{{old('onlineLink')}}"
                                rows="4" class="focus:border-neutral-400 focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" 
                                placeholder="Online Platform link"
                            >
                            </textarea>
                        </div>
                        <div class="xl:w-1/2 w-full flex flex-col gap-4">
                            <h4 class="text-md text-slate-600/80 font-bold">Venue Location</h4>
                            <div class="flex xl:flex-row flex-col gap-2">
                                <input 
                                    name="address" value="{{old('address')}}"
                                    type="text"
                                    class="focus:border-neutral-400 focus:ring-0 w-3/4 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" 
                                    placeholder="Address" />
                                <input 
                                    name="postalCode" value="{{old('postalCode')}}"
                                    class="focus:border-neutral-400 w-1/4 focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Postal Code" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <p class="text-sm text-slate-500 leading-snug">Add Map Coordinates<em>(Optional)</em></p>
                                <div class="flex gap-2">
                                    <input name="latitude" value="{{old('latitude')}}"
                                        class="w-full focus:border-neutral-400 focus:ring-0 rounded-none bg-zinc-50/60 border-b border-x-0 border-t-0 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Latitude" />
                                    <input name="latitude" value="{{old('longitude')}}"
                                        class="w-full focus:border-neutral-400 focus:ring-0 rounded-none bg-zinc-50/60 border-b border-x-0 border-t-0 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Latitude" />
                                </div>

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
                    <div class="flex xl:flex-row flex-col justify-between gap-4">
                        <div class="flex flex-col w-full gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Email Address 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactEmail" value="{{old('contactEmail')}}"
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Email Address" />
                        </div>
                        <div class="flex flex-col w-full gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Contact Number 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactNumber" value="{{old('contactNumber')}}"
                                class="focus:border-neutral-400 focus:ring-0 flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" type="text" placeholder="Phone or Mobile Number" />
                        </div>
                        <div class="flex flex-col w-full gap-1">
                            <p class="text-md text-slate-500 capitalize">
                                Contact Person 
                                <span class="text-md italic text-red-400">*</span>
                            </p>
                            <input 
                                name="contactPerson" value="{{old('contactPerson')}}"
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

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-md text-slate-500 capitalize mb-1">Excerpt <span class="text-md italic text-red-400">*</span></p>
                        <textarea 
                            rows="3" 
                            placeholder="Short Description"
                            name="excerpt"
                            {{-- maxlength="300" --}}
                            value="{{old('excerpt')}}"
                            class="min-h-[100px] focus:border-neutral-400 focus:ring-0 flex items-center rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface"></textarea>
                        <em class="text-slate-500 italic pt-2 text-sm">Maximum of 300 characters</em>
                    </div>
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <p class="text-lg text-slate-700 capitalize font-bold mb-1">Price <span class="text-md italic text-red-400">*</span></p>
                    <div class="relative mb-4 flex flex-wrap items-stretch">
                        <span
                            class="flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-e-0 border-solid border-neutral-400 px-3 py-2 text-center text-base font-normal text-surface"
                            id="basic-addon1"
                            >SGD$</span
                        >
                        <input
                            type="text"
                            name="price"
                            value="{{old('price')}}"
                            class="relative m-0 block flex-auto rounded-none border border-solid border-neutral-400 bg-zinc-50 focus:ring-0 bg-clip-padding px-3 py-2 text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-neutral-400 focus:shadow-inset focus:outline-none motion-reduce:transition-none"
                            placeholder="Price"
                            aria-label="price"
                            aria-describedby="basic-addon1" />
                    </div>
                    <p class="text-lg text-slate-700 capitalize font-bold">Admin Fee 
                        {{-- <span class="text-md italic text-red-400">*</span> --}}
                    </p>
                    <p class="text-sm text-slate-500 italic leading-snug">Add service or admin fee.</p>
                    <p class="text-sm text-slate-500 mb-2 italic leading-snug">This will be added during checkout</p>
                    <div class="relative mb-4 flex flex-wrap items-stretch">
                    <span
                        class="flex items-center whitespace-nowrap rounded-none bg-zinc-50 border border-e-0 border-solid border-neutral-400 px-3 py-2 text-center text-base font-normal text-surface"
                        id="basic-addon1"
                        >SGD$</span
                    >
                    <input
                        type="text"
                        name="adminFee"
                        value="{{old('adminFee')}}"
                        class="relative m-0 block flex-auto rounded-none border border-solid border-neutral-400 bg-zinc-50 focus:ring-0 bg-clip-padding px-3 py-2 text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-neutral-400 focus:shadow-inset focus:outline-none motion-reduce:transition-none"
                        placeholder="Admin Fee"
                        aria-label="admin_fee"
                        aria-describedby="basic-addon1" />
                    </div>
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold">External Link <em class="text-sm">(Optional)</em></h4>
                    <p class="text-sm text-slate-500 mb-2 italic leading-snug">If programme has 3rd party registration link</p>
                    <input 
                        class="focus:border-neutral-400 placeholder:italic w-full focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" 
                        name="externalUrl" 
                        value="{{old('externalUrl')}}" 
                        type="text" 
                        placeholder="www.external.url" 
                    />
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold mb-4">Status</h4>
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="private_only" value="{{old('private_only')}}" class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                        <span>Private Only</span>
                    </label>
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="searchable" value="{{old('searchable')}}" class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                        <span>Make it Searchable</span>
                    </label>
                    <label class="flex items-center space-x-2 mb-1">
                        <input type="checkbox" name="searchable" value="{{old('searchable')}}" class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0">
                        <span>Make it Publishable</span>
                    </label>
                    <br />
                    <div>
                        <h4 class="text-xl text-slate-600 capitalize font-bold">Participants Limit</h4>
                        <p class="text-sm text-slate-500 italic leading-snug">(Optional) Set a maximum registration</p>
                        <p class="text-sm text-slate-500 mb-2 italic leading-snug">Set 0 for unlimited participants</p>
                        <input 
                            class="focus:border-neutral-400 xl:w-1/3 placeholder:italic w-full focus:ring-0 rounded-none bg-zinc-50 border border-solid border-neutral-400 px-3 py-2 text-base font-normal text-surface" 
                            name="externalUrl" 
                            value="{{old('externalUrl')}}" 
                            type="number" 
                            placeholder="0" 
                        />
                    </div>
                </div>

                <div class="shadow-md p-4 border border-slate-400/70 rounded bg-white">
                    <h4 class="text-xl text-slate-600 capitalize font-bold mb-4">Categories</h4>
                    <x-category-checkboxes 
                        :categories="$categories" 
                    />
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded-none bg-white">
                    <x-upload-image class="bg-zinc-200/70 min-h-[150px] border-zinc-400/40" emptyLabel="Thumbnail" name="thumb" />
                </div>
                <div class="shadow-md p-4 border border-slate-400/70 rounded-none bg-white">
                    <x-upload-image 
                        class="bg-zinc-200/70 min-h-[250px] border-zinc-400/40" 
                        emptyLabel="Upload Poster" 
                        name="a3_poster" 
                    />
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

