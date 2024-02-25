@push('styles')
    <style>
        p.text-sm.text-gray-700.leading-5 {
            display: none;
        }
    </style>
@endpush

<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            {{-- table header --}}
            <div class="m-4">
                <h5 class="text-lg font-bold text-gray-900 dark:text-white">List Submission</h5>
                <p class="mt-1 mb-4 text-gray-500 dark:text-gray-400 font-normal text-sm">This feature is available exclusively for Coordinators</p>
                
                {{-- alert --}}
                <div class="my-4 ">
                    @if (session()->has('success'))
                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 3000)"
                            class="alert-remove p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" 
                            role="alert"
                        >{{ session('success') }}</div>
                    @endif

                    @if (session()->has('error'))
                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 3000)"
                            class="alert-remove p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" 
                            role="alert"
                        >{{ session('error') }}</div>
                    @endif
                </div>

                {{-- search  --}}
                <div class="relative bg-white dark:bg-gray-800 rounded-lg">
                    <div class="flex flex-col items-center justify-between space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <input wire:model="search" type="text" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required="">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- table --}}
            <div class="m-4">
                @if($proposals_process->isEmpty())
                    <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                        <div class="block max-w-sm">
                            <img src="/assets/illustrations/waiting1.svg" alt="astronaut image">
                        </div>
                        <div class="text-center xl:max-w-4xl mt-5">
                            <h1 class="mb-3 text-base font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">📢 No Student Proposals Submitted Yet</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Currently, there are no submitted student proposals. We encourage students to take the initiative and submit their innovative ideas!</p>
                        </div>
                    </div>
                @else
                    <div class="my-4">
                        <ol class="mt-3 divide-y divider-gray-200 dark:divide-gray-700">
                            @foreach($proposals_process as $proposal_process)
                                <li>
                                    <a href="#" wire:click="checkProposal({{ $proposal_process->id }})" wire:click.prevent class="items-center block px-1 py-3 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                                        @if($proposal_process->student->user->avatar)
                                            <img class="mr-3 object-cover w-10 h-10 rounded-full" src="{{ asset('storage/avatars/'.$proposal_process->student->user->avatar) }}" alt="avatar"/>
                                        @else                    
                                            <img class="mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($proposal_process->student->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="40">
                                        @endif
                                        <div class="text-gray-600 dark:text-gray-400">
                                            <div class="md:flex md:justify-center md:items-center">
                                                <div class="mr-2 text-base font-normal">
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $proposal_process->student->user->name }}</span>
                                                </div>
                                                <div class="text-sm font-normal">
                                                    @if($proposal_process->type == 'thesis')
                                                        <span class="align-center bg-green-100 text-green-800 text-xs font-medium p-0.5 rounded dark:bg-green-900 dark:text-green-300">Thesis</span>
                                                    @elseif($proposal_process->type == 'appropriate_technology')
                                                        <span class="align-center bg-purple-100 text-purple-800 text-xs font-medium p-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Appropriate Technology</span>
                                                    @elseif($proposal_process->type == 'journal')
                                                        <span class="align-center bg-yellow-100 text-yellow-800 text-xs font-medium p-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Journal</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <span class="inline-flex items-center text-xs font-normal text-blue-500 dark:text-blue-400">
                                                <svg class="w-2.5 h-2.5 mr-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"/></svg>
                                                {{ Illuminate\Support\Carbon::parse($proposal_process->updated_at)->diffForHumans() }}
                                            </span> 
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif
            </div>

            {{-- table footer --}}
            <div class="m-4">
                {{ $proposals_process->links() }}
            </div>

        </div>
    </div>
</div>
