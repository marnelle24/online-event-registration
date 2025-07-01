<div class="w-full">
    <div class="flex flex-col gap-9">
        <div class="rounded-sm border border-slate-300 bg-white shadow-default">
            <div class="border-b border-slate-300 bg-slate-100 p-5">
                <h3 class="font-medium text-black">Add New Professional</h3>
                <p class="text-sm text-slate-800">(Speaker, Trainer, Facilitator, etc.)</p>
            </div>
            <form wire:submit.prevent="save" class="flex flex-col gap-4 p-5">
                <div>
                    <label class="mb-1 block text-sm font-medium text-black">Assign as</label>
                    <select 
                        wire:model="form.role"
                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary">
                        <option value="" disabled selected>Select</option>
                        <option value="Speaker">Speaker</option>
                        <option value="Trainer">Trainer</option>
                        <option value="Facilitator">Facilitator</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('form.title') 
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-black">Title</label>
                    <select 
                        wire:model="form.title"
                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary">
                        <option value="" disabled selected>Select Title</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Prof.">Prof.</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('form.title') 
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-black">Name</label>
                    <input 
                        wire:model="form.name"
                        type="text" placeholder="Name" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" />
                    @error('form.name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-black">Profession</label>
                    <input 
                        wire:model="form.profession"
                        type="text" placeholder="Profession" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" />
                    @error('form.profession')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-black">Email Address</label>
                    <input 
                        wire:model="form.email"
                        type="email" placeholder="Email Address" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" />
                    @error('form.email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-black">About</label>
                    <textarea 
                        wire:model="form.about"
                        placeholder="Short Bio" rows="4" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"></textarea>
                    @error('form.about')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="flex gap-2 text-sm font-medium text-black">
                        Social Media Accounts
                        <button wire:click="addSocMedAccount" type="button" class="text-sky-600 duration-300 hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                        </button>
                    </label>
                    @foreach ($form['socials'] as $index => $socmed)
                        <div class="mt-3 flex gap-2">
                            <button wire:click="removeSocMedAccount({{ $index }})" type="button" class="text-red-500 text-xl hover:scale-110 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                  </svg>
                            </button>
                            <select wire:model="form.socials.{{ $index }}.platform" class="w-1/3 border-b focus:ring-0 focus:border-slate-600 border border-slate-500 text-sm">
                                <option value="" disabled selected>Select</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Twitter">X</option>
                                <option value="LinkedIn">LinkedIn</option>
                                <option value="Instagram">Instagram</option>
                                <option value="YouTube">YouTube</option>
                                <option value="Other">Other</option>
                            </select>
                            <input wire:model="form.socials.{{ $index }}.url"
                                type="text" class="w-2/3 border-b focus:ring-0 focus:border-slate-600 border border-slate-500 text-sm" placeholder="Link" />
                        </div>
                    @endforeach
                    @error('form.socials.*.platform') 
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="border-t border-slate-400 pt-4 space-y-2">      
                    <p class="text-slate-700 text-md">Thumbnail</p>        
                    <div class="flex flex-col items-center justify-center border border-dashed bg-gray {{$thumbnail ? 'p-2' : 'p-4'}} space-y-3">
                        @if ($thumbnail)
                            <div class="mt-2">
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full object-cover rounded border border-gray-300" />
                            </div>
                        @else
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.99967 9.33337C2.36786 9.33337 2.66634 9.63185 2.66634 10V12.6667C2.66634 12.8435 2.73658 13.0131 2.8616 13.1381C2.98663 13.2631 3.1562 13.3334 3.33301 13.3334H12.6663C12.8431 13.3334 13.0127 13.2631 13.1377 13.1381C13.2628 13.0131 13.333 12.8435 13.333 12.6667V10C13.333 9.63185 13.6315 9.33337 13.9997 9.33337C14.3679 9.33337 14.6663 9.63185 14.6663 10V12.6667C14.6663 13.1971 14.4556 13.7058 14.0806 14.0809C13.7055 14.456 13.1968 14.6667 12.6663 14.6667H3.33301C2.80257 14.6667 2.29387 14.456 1.91879 14.0809C1.54372 13.7058 1.33301 13.1971 1.33301 12.6667V10C1.33301 9.63185 1.63148 9.33337 1.99967 9.33337Z" fill="#3C50E0" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5286 1.52864C7.78894 1.26829 8.21106 1.26829 8.4714 1.52864L11.8047 4.86197C12.0651 5.12232 12.0651 5.54443 11.8047 5.80478C11.5444 6.06513 11.1223 6.06513 10.8619 5.80478L8 2.94285L5.13807 5.80478C4.87772 6.06513 4.45561 6.06513 4.19526 5.80478C3.93491 5.54443 3.93491 5.12232 4.19526 4.86197L7.5286 1.52864Z" fill="#3C50E0" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99967 1.33337C8.36786 1.33337 8.66634 1.63185 8.66634 2.00004V10C8.66634 10.3682 8.36786 10.6667 7.99967 10.6667C7.63148 10.6667 7.33301 10.3682 7.33301 10V2.00004C7.33301 1.63185 7.63148 1.33337 7.99967 1.33337Z" fill="#3C50E0" />
                                </svg>
                            </span>
                            <p class="text-sm font-medium">
                                <span class="text-primary">Click to upload</span> thumbnail
                            </p>
                            <p class="mt-1.5 text-sm font-medium">
                                PNG, JPG or JPEG
                            </p>
                            <p class="text-sm font-medium">
                                (max, 800 X 800px) or 1.5MB
                            </p>
                        @endif
                    </div>
                    <input type="file" wire:model="thumbnail" class="file:border-slate-200 file:bg-slate-200 file:border-none file:p-2 file:text-sm w-full border border-slate-400 bg-zinc-100" />
                
                    @error('thumbnail') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                    <div wire:loading wire:target="thumbnail" class="text-sm text-blue-500">
                        Uploading...
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center bg-primary hover:bg-primary-dark duration-300 rounded-md justify-center px-4 py-2 text-white font-medium text-sm">
                        Save
                    </button>
                    <button wire:click="resetForm" type="reset" class="ml-2 inline-flex items-center bg-slate-300 hover:bg-slate-400 duration-300 rounded-md justify-center px-4 py-2 text-slate-600 font-medium text-sm">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
