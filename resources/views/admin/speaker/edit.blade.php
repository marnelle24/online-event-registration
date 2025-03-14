@section('title', 'Edit Speaker')
<x-app-layout>
    <h4 class="text-2xl font-bold text-black dark:text-slate-600 mb-8 capitalize">Edit Speaker</h4>
    
    @if ($errors->any())
        <div class="bg-red-100 border flex justify-between items-center border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <div>
                <span class="block sm:inline text-sm font-bold">Please fix the following errors:</span>
                <ul class="list-none list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-xs">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="close" onclick="this.parentElement.remove()" aria-label="Close">
                <span aria-hidden="true" class="text-red-700 text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <div class="flex gap-4">
        <form action="{{ route('admin.speakers.update', $speaker->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                @csrf
                @method('PUT')
                <div class="flex gap-4">
                    <div class="w-full lg:w-2/3">
                        <div class="flex lg:flex-row flex-col gap-3 mb-4">
                            <div class="w-1/3">
                                <label for="title" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title (Dr., Prof., etc.)"
                                    value="{{ old('title', $speaker->title) }}" 
                                    class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                            </div>
    
                            <div class="w-2/3">
                                <label for="name" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Name</label>
                                <input type="text" name="name" id="name" placeholder="Full Name"
                                    value="{{ old('name', $speaker->name) }}"
                                    class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email Address"
                                value="{{ old('email', $speaker->email) }}"
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                        </div>

                        <div class="flex lg:flex-row flex-col gap-3 mb-4">
                            <div class="w-full lg:w-1/2">
                                <label for="profession" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Profession</label>
                                <input type="text" name="profession" id="profession" placeholder="Profession"
                                    value="{{ old('profession', $speaker->profession) }}"
                                    class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                            </div>
                            <div class="w-full lg:w-1/2">
                                <label for="is_active" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Status</label>
                                <select name="is_active" id="is_active" 
                                    class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                    <option value="1" {{ old('is_active', $speaker->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $speaker->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <label class="block text-gray-700 dark:text-white text-sm font-bold mb-1 mt-6">Social Media</label>
                        <div class="mb-4 border border-slate-400/70 dark:border-slate-500/70 p-4">
                            <!-- Twitter -->
                            <div class="flex lg:flex-row flex-col gap-3 mb-3">
                                <div class="w-full lg:w-1/3">
                                    <input type="text" name="socials[twitter][name]" 
                                        value="{{ old('socials.twitter.name', $speaker->socials['twitter']['name'] ?? 'Twitter') }}" readonly
                                        class="w-full rounded-none bg-zinc-100 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                </div>
                                <div class="w-full lg:w-2/3">
                                    <input type="url" name="socials[twitter][url]" 
                                        placeholder="https://twitter.com/username"
                                        value="{{ old('socials.twitter.url', $speaker->socials['twitter']['url'] ?? '') }}"
                                        class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                </div>
                            </div>

                            <!-- LinkedIn -->
                            <div class="flex lg:flex-row flex-col gap-3 mb-3">
                                <div class="w-full lg:w-1/3">
                                    <input type="text" name="socials[linkedin][name]" 
                                        value="{{ old('socials.linkedin.name', $speaker->socials['linkedin']['name'] ?? 'LinkedIn') }}" readonly
                                        class="w-full rounded-none bg-zinc-100 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                </div>
                                <div class="w-full lg:w-2/3">
                                    <input type="url" name="socials[linkedin][url]" 
                                        placeholder="https://linkedin.com/in/username"
                                        value="{{ old('socials.linkedin.url', $speaker->socials['linkedin']['url'] ?? '') }}"
                                        class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                </div>
                            </div>

                            <!-- Facebook -->
                            <div class="flex lg:flex-row flex-col gap-3">
                                <div class="w-full lg:w-1/3">
                                    <input type="text" name="socials[facebook][name]" 
                                        value="{{ old('socials.facebook.name', $speaker->socials['facebook']['name'] ?? 'Facebook') }}" readonly
                                        class="w-full rounded-none bg-zinc-100 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                </div>
                                <div class="w-full lg:w-2/3">
                                    <input type="url" name="socials[facebook][url]" 
                                        placeholder="https://facebook.com/username"
                                        value="{{ old('socials.facebook.url', $speaker->socials['facebook']['url'] ?? '') }}"
                                        class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-full lg:w-1/3">
                        <div class="mb-4">
                            <label for="thumbnail" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Profile Photo</label>
                            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-slate-900/40 bg-zinc-50 dark:bg-slate-800 px-6 py-10">
                                <div class="text-center">
                                    <img id="preview" 
                                         src="{{ $speaker->thumbnail ? Storage::url($speaker->thumbnail) : '' }}" 
                                         class="mx-auto h-32 w-32 rounded-full object-cover {{ $speaker->thumbnail ? '' : 'hidden' }}">
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                        <label for="thumbnail" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500 px-2 border border-slate-400/70">
                                            <span>Upload a file</span>
                                            <input id="thumbnail" name="thumbnail" type="file" class="sr-only" onchange="previewImage()">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="mt-4 text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="about" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Short Credential</label>
                            <textarea name="about" id="about" rows="4" placeholder="Short Credential"
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">{{ old('about', $speaker->about) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('admin.speakers') }}" 
                   class="text-slate-600 bg-slate-100 hover:bg-slate-200 dark:bg-slate-300 dark:hover:bg-slate-400 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-3 px-5 mr-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex items-center hover:-translate-y-1 duration-300 justify-center rounded-full bg-slate-600 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-slate-700 py-3 px-6 font-medium text-white">
                    Update Speaker
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage() {
            const preview = document.getElementById('preview');
            const file = document.getElementById('thumbnail').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        }
    </script>
</x-app-layout> 