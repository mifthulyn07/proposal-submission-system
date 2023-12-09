<div>
    <div class="m-4">
        <h5 class="text-lg font-medium text-gray-900 dark:text-white">Complete Verification</h5>
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

                {{-- proposal --}}
                <div class="mb-4">
                    <div>
                        <label for="requirements_pdf" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Requirements: pdf</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" id="file-upload-input" wire:model="requirements_pdf" multiple>
                        @if($requirements_pdf)
                            @foreach ($requirements_pdf as $requirement_pdf)
                                @if(file_exists($requirement_pdf->getRealPath()))
                                    <span class="mt-2 text-sm text-gray-800 dark:text-gray-800"> {{ $requirement_pdf->getClientOriginalName() }} </span> 
                                @endif
                            @endforeach 
                        @endif
                    </div>
                    @error('requirements_pdf.*') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    @error('requirements_pdf') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">you need supporting request letters. Please refer to the proposal submission instructions for details.</p>                      
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
