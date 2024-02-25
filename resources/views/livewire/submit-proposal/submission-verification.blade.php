<div>
    <div class="m-4">
        <h5 class="text-lg font-bold text-gray-900 dark:text-white">Complete Verification</h5>
        <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">You're almost there! Please fill out the form below to verify and finalize your proposal submission.</p>
        
        {{-- form proposal process --}}
        <div class="mt-4 ">
            <form wire:submit.prevent="createProposalProcess" enctype="multipart/form-data">
                
                {{-- type --}}
                <div class="mb-4">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of Proposal</label>
                    <select id="type" name="type" wire:model="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option hidden>Choose Type of Proposal</option>
                        <option value="thesis">Thesis</option>
                        <option value="appropriate_technology">Appropriate Technology</option>
                        <option value="journal">Journal</option>
                    </select>
                    @error('type') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                </div>

                {{-- date --}}
                <div class="mb-4">
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Date</label>
                    <input type="date" disabled wire:model="date" id="date" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('date') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <h2 class="mb-2 text-md font-semibold text-gray-900 dark:text-white">Please submit the following documents in one file:</h2>
                    <ol class="list-decimal list-inside max-w-md space-y-1 text-gray-500 dark:text-gray-400">
                        <li>Study plan card (for the active semester)</li>
                        <li>Academic transcript</li>
                        <li>Internship report approval sheet</li>
                        <li>Proposal registration form</li>
                        <li>Advisor verification form</li>
                    </ol>
                </div>

                {{-- requirements --}}
                <div class="mb-4">
                    <div>
                        <label for="requirements" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Requirements: pdf</label>
                        <input type="file" id="file-upload-input" wire:model="requirements" class="hidden">
                        <x-secondary-button class="mr-2 py-2 mt-1" id="file-upload-button">{{ __('Upload File') }}</x-secondary-button>
                        @if($requirements) 
                            <span class="mt-2 text-sm text-gray-800 dark:text-gray-800"> {{ $requirements->getClientOriginalName() }} </span> 
                        @endif
                    </div>
                    @error('requirements') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">To submit your proposal, please use the provided template and follow the submission procedures.</p>
                </div>

                {{-- button --}}
                <div class="flex justify-between mt-6">
                    {{-- button back --}}
                    <button type="button" wire:click="back" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Back
                    </button>
                    {{-- button next --}}
                    <button type="submit" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Next Step: Finish Submision
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>
