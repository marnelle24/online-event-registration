<!-- Bank Transfer Modal Component -->
<div x-show="showBankTransferModal"
     x-cloak
     @keydown.escape.window="showBankTransferModal = false"
     class="bank-transfer-modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    
    <!-- Modal backdrop -->
    <div x-show="showBankTransferModal" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 opacity-75 backdrop-blur-sm bg-black"
         @click="showBankTransferModal = false"></div>

    <!-- Modal content -->
    <div x-show="showBankTransferModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative p-8 lg:top-10 top-2 mx-auto border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white z-50">
        
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <span x-text="bankTransferInstructions?.title || 'Bank Transfer Instructions'"></span>
                </h3>
                <button @click="showBankTransferModal = false" 
                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="mt-2 text-sm text-gray-700">
                <!-- Amount Section -->
                <div x-show="bankTransferInstructions?.amount" class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <p class="font-bold">Amount to Transfer:</p>
                    <p class="text-2xl font-bold text-blue-900">
                        {{-- <span x-text="bankTransferInstructions?.currency || '$'"></span> --}}
                        <span>$</span>
                        <span x-text="bankTransferInstructions?.amount ? parseFloat(bankTransferInstructions.amount).toFixed(2) : '0.00'"></span>
                    </p>
                    <p x-show="bankTransferInstructions?.reference_no" class="text-xs mt-1">
                        Reference: <span class="font-mono font-bold" x-text="bankTransferInstructions?.reference_no"></span>
                    </p>
                </div>
                
                <!-- Instruction Steps -->
                <div x-show="bankTransferInstructions?.steps && bankTransferInstructions.steps.length > 0" class="space-y-4 mb-6">
                    <template x-for="(step, index) in bankTransferInstructions?.steps || []" :key="index">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-500 text-white font-bold text-sm"
                                     x-text="step.step || (index + 1)"></div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-semibold text-gray-900" x-text="step.title"></h4>
                                <div class="mt-1 text-sm text-gray-600" x-html="step.content"></div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- Important Notes -->
                <div x-show="bankTransferInstructions?.important_notes && bankTransferInstructions.important_notes.length > 0" 
                     class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <h4 class="text-sm font-semibold text-yellow-800 mb-2">Important Notes:</h4>
                    <ul class="list-disc list-inside space-y-1 text-sm text-yellow-700">
                        <template x-for="(note, index) in bankTransferInstructions?.important_notes || []" :key="index">
                            <li x-text="note"></li>
                        </template>
                    </ul>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="showBankTransferModal = false"
                        class="px-4 py-2 bg-slate-100 text-slate-800 border border-slate-200 text-base font-medium rounded-md hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                    Close
                </button>
                <button @click="window.print()"
                        class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Instructions
                </button>
            </div>
        </div>
    </div>
</div>
