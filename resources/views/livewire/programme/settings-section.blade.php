<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex justify-between items-center border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="font-medium text-md text-slate-500">
                Additional & Custom Settings
            </p>
        </div>
        <div class="border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <table class="w-full">
                <tr>
                    <td width="25%" class="py-2">Turn on invitation only mode</td>
                    <td class="p-2 w-14">
                        <label for="toggle4" class="cursor-pointer select-none items-center">
                            <div x-data="{ isActive: @entangle('invitationOnly') }" class="relative">
                                <input 
                                    wire:model="invitationOnly"
                                    type="checkbox" id="toggle4" class="sr-only" />
                                <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                            </div>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">Make it searchable</td>
                    <td class="p-2 w-14">
                        <label for="toggle5" class="cursor-pointer select-none items-center">
                            <div x-data="{ isActive: @entangle('searchable') }" class="relative">
                                <input 
                                    wire:model="searchable"
                                    type="checkbox" id="toggle5" class="sr-only" />
                                <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                            </div>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">Make it publishable</td>
                    <td class="p-2 w-14">
                        <label for="toggle6" class="cursor-pointer select-none items-center">
                            <div x-data="{ isActive: @entangle('publishable') }" class="relative">
                                <input 
                                    wire:model="publishable"
                                    type="checkbox" id="toggle6" class="sr-only" />
                                <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                            </div>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">
                        Admin Fee
                    </td>
                    <td class="p-2 w-full flex gap-2">
                        <input 
                            type="number"
                            step="0.10" 
                            class="group w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                            placeholder="SGD 0.00" 
                        />
                        <button class="font-bold shadow p-1 rounded-md bg-success hover:bg-green-800/80 hover:scale-105 duration-300 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">
                        Incharge Email Address
                    </td>
                    <td class="p-2 w-full flex gap-2">
                        <input 
                            type="email" 
                            class="group w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                            placeholder="Incharge Email Address" 
                        />
                        <button class="font-bold shadow p-1 rounded-md bg-success hover:bg-green-800/80 hover:scale-105 duration-300 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">
                        Cheque Number
                        <p class="text-xs italic text-slate-500">(Check code for cheque payments)</p>
                    </td>
                    <td class="p-2 w-full flex gap-2">
                        <input 
                            type="number" 
                            step="1" 
                            class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                            placeholder="Cheque Code" 
                        />
                        <button class="font-bold shadow p-1 rounded-md bg-success hover:bg-green-800/80 hover:scale-105 duration-300 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">Adjust maximum registrant</td>
                    <td class="p-2 w-full flex gap-2">
                        <input 
                            type="number" 
                            step="1" 
                            class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" 
                            placeholder="Max Registrant" 
                        />
                        <button class="font-bold shadow p-1 rounded-md bg-success hover:bg-green-800/80 hover:scale-105 duration-300 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">External Registration Link</td>
                    <td class="p-2 w-full flex gap-2">
                        <input type="text" class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" placeholder="https://invitation-link-here.com" />
                        <button class="font-bold shadow p-1 rounded-md bg-success hover:bg-green-800/80 hover:scale-105 duration-300 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">Registration validity period 
                        <p class="text-xs italic text-slate-500">(Adjust active until date)</p>
                    </td>
                    <td class="p-2 w-full flex gap-2">
                        <input type="datetime-local" class="w-1/2 rounded-md border border-slate-400 focus:ring-0 focus:border-slate-600 outline-none" placeholder="https://invitation-link-here.com" />
                        <button class="font-bold shadow p-1 rounded-md bg-success hover:bg-green-800/80 hover:scale-105 duration-300 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-4 flex item">Status</td>
                    <td class="p-4 w-full">
                        <div class="flex flex-col gap-2">
                            <label class="flex gap-1">
                                <input type="radio" wire:model="programmeStatus" value="published" />
                                <span>Publish</span>
                            </label>
                            <label class="flex gap-1">
                                <input type="radio" wire:model="programmeStatus" value="unpublished" />
                                <span>Unpublished</span>
                            </label>
                            <label class="flex gap-1">
                                <input type="radio" wire:model="programmeStatus" value="draft" />
                                <span>Draft</span>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="25%" class="py-2">  
                        <button class="font-thin tracking-wider uppercase drop-shadow shadow py-3 px-4 text-sm rounded-full text-white border border-danger/60 bg-danger/70 hover:bg-danger/80 hover:scale-105 duration-300">
                            Archive
                        </button>
                    </td>
                    <td class="p-2 w-full flex gap-2">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
