<div>
    <div class="m-4">
        <h5 class="text-lg font-bold text-gray-900 dark:text-white">Ready to Submit Your Proposal?</h5>
        <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Submitting your proposal is a breeze! Just follow these three simple steps. Plus, ensure your title's uniqueness by using our built-in similarity checker tool.</p>
        
        {{-- alert --}}
        <div class="mt-4 ">
            @if (session()->has('success-submit'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="alert-remove p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" 
                    role="alert"
                >{{ session('success-submit') }}</div>
            @endif

            @if (session()->has('error-submit'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="alert-remove p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" 
                    role="alert"
                >{{ session('error-submit') }}</div>
            @endif
        </div>

        {{-- table header  --}}
        <div class="mt-4 relative bg-white dark:bg-gray-800 rounded-lg">
            <div class="flex flex-col items-center justify-between space-y-3 md:flex-row md:space-y-0 md:space-x-4">

                {{-- button add  --}}
                <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                        New Proposal Submission
                    </button>
                </div>
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        {{-- <li>
                            <a href="{{ Route('submit-proposal.create', $proposalProcess->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Create Manual</a>
                        </li> --}}
                        <li>
                            <a href="{{ Route('submit-proposal.similarity.create', $proposalProcess->slug) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Create through Check Similarity Fitur</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- table --}}
        <div class="mt-4 @if(!$submit_proposals->isEmpty()) relative overflow-x-auto overflow-y-hidden rounded-lg shadow-sm @endif">
            @if($submit_proposals->isEmpty())
                <div class="m-4">
                    <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                        <div class="flex justify-center block max-w-sm">
                            <img src="/assets/illustrations/500.svg" alt="waiting image" width="80%">
                        </div>
                        <div class="text-center xl:max-w-4xl">
                            <h1 class="mb-3 text-base font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">🚀 Your proposal could be a game-changer!</h1>
                            <p class="text-sm font-normal text-gray-600 dark:text-gray-400">Let's embark on your submission journey and make an impact with your proposal.</p>
                        </div>
                    </div>
                </div>            
            @else
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input wire:model='selectAll' type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Proposal's Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                topic
                            </th>
                            <th scope="col" class="px-6 py-3">
                                similarity
                            </th>
                            <th scope="col" class="px-6 py-3">
                                proposal
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submit_proposals as $submit_proposal)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input wire:model="selectedProposals" value={{ $submit_proposal->id }} type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$submit_proposal->title}}
                                </th>
                                <td class="px-6 py-4">
                                    @if($submit_proposal->topic)
                                        {{$submit_proposal->topic->name}}
                                    @else
                                        {{$submit_proposal->adding_topic}}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($submit_proposal->similarity === null)
                                        -
                                    @else
                                        {{$submit_proposal->similarity}}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('print.view-pdf', $submit_proposal->proposal) }}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                                </td>
                                <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                                    <a data-tooltip-target="tooltip-edit" wire:click="editIdSubmitProposal({{ $submit_proposal->id }})" wire:click.prevent class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-300 dark:hover:bg-yellow-300 dark:focus:ring-yellow-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                    </a>
                                    <a data-tooltip-target="tooltip-delete" wire:click="deleteIdSubmitProposal({{ $submit_proposal->id }})" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-submitProposal-deletion')">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Delete
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <div id="tooltip-download" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Download
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            @endif
        </div>
        
        {{-- button next step --}}
        <div class="flex items-center justify-end gap-4 mt-6">
            <div>
                @if (session()->has('error'))
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm text-red-600"
                    >{{ session('error') }}</p>
                @endif
            </div>
            @if(!$submit_proposals->isEmpty())
                <button type="submit" wire:click="proposalSubmit()" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Next Step: Verification
                </button>
            @endif
        </div>

        {{-- delete modal --}}
        <x-modal wire:ignore.self name="confirm-submitProposal-deletion" :show="$errors->submitProposalDeletion->isNotEmpty()" focusable>
            <div class="p-6">
                <div class="p-2 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete <span class="text-gray-900 font-semibold">{{ $deleteIdSubmitProposalTitle }}</span>?</h3>
                </div>

                <div class="flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" wire:click.prevent="deleteSubmitProposal()" x-on:click="$dispatch('close')">
                        <span wire:loading.remove>{{ __('Delete') }}</span>
                        <span wire:loading>
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                        </span>
                    </x-danger-button>
                </div>
            </div>
        </x-modal>
    </div>
</div>
