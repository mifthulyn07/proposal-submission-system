<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        {{-- desc --}}
        <div class="@if($showResultSubmit == true) hidden @endif bg-white overflow-hidden rounded-lg shadow rounded-lg">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">

                    {{-- profile --}}
                    <div class="flex items-center space-x-4">
                        @if($proposalProcess->student->user->avatar)
                            <button data-popover-target="popover-company-profile">
                                <img class="object-cover w-12 h-12 rounded-full" src="{{ asset('storage/avatars/'.$proposalProcess->student->user->avatar) }}" alt="avatar"/>
                            </button>
                        @else
                            <button data-popover-target="popover-company-profile">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($proposalProcess->student->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="50">
                            </button>
                        @endif
                        <div class="space-y-1 font-medium dark:text-white">
                            <div class="lg:flex">
                                <p class="mr-2 font-bold">{{ $proposalProcess->student->user->name }}</p>
                                @if($proposalProcess->type == 'thesis')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium mr-0.5 mb-1 p-1 rounded dark:bg-green-900 dark:text-green-300">Thesis</span>
                                @elseif($proposalProcess->type == 'appropriate_technology')
                                    <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-0.5 mb-1 p-1 rounded dark:bg-purple-900 dark:text-purple-300">Appropriate Technology</span>
                                @elseif($proposalProcess->type == 'journal')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-0.5 mb-1 p-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Journal</span>
                                @endif
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                {{ $proposalProcess->student->nim}}
                            </div>
                        </div>
                    </div>

                    {{-- popup detail profile--}}
                    <div data-popover id="popover-company-profile" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-80 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                        <div class="p-3">
                            <div class="flex">
                                <div class="mr-3 shrink-0">
                                    <div href="#" class="block p-2 bg-gray-100 rounded-lg dark:bg-gray-700">
                                        @if($proposalProcess->student->user->avatar)
                                            <img class="object-cover w-10 h-10 rounded-full" src="{{ asset('storage/avatars/'.$proposalProcess->student->user->avatar) }}" alt="avatar"/>
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($proposalProcess->student->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="38">
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-1 text-base font-semibold leading-none text-gray-900 dark:text-white">
                                        {{ $proposalProcess->student->user->name }}
                                    </p>
                                    <p class="mb-3 text-sm font-normal">
                                        {{ $proposalProcess->student->user->email }}
                                    </p>
                                    <ul class="mb-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                                        <li class="flex items-center">
                                            <svg data-tooltip-target="tooltip-gender" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/></svg>
                                            <div id="tooltip-gender" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Gender <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            @if($proposalProcess->student->user)
                                                {{ ucfirst($proposalProcess->student->user->gender) }}
                                            @endif
                                        </li>
                                        <li class="flex items-center">
                                            <svg data-tooltip-target="tooltip-phone" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18"><path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z"/></svg>
                                            <div id="tooltip-phone" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Phone <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            @if($proposalProcess->student->user)
                                                {{ $proposalProcess->student->user->phone }}
                                            @endif
                                        </li>
                                        <li class="flex items-center">
                                            <svg data-tooltip-target="tooltip-class" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/><path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/></svg>
                                            <div id="tooltip-class" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Class <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            @if($proposalProcess->student)
                                                {{ $proposalProcess->student->class }}
                                            @endif
                                        </li>
                                        <li class="flex items-center">
                                            <svg data-tooltip-target="tooltip-supervisor" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 18"><path d="M7 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm2 1H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/></svg>
                                            <div id="tooltip-supervisor" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Supervisor <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            @if($proposalProcess->student->lecturer)
                                                {{ $proposalProcess->student->lecturer->user->name }}
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div data-popper-arrow></div>
                    </div>

                    {{-- see others button --}}
                    @if($count_submission > 1)
                        <a href="{{ route('check-proposal.submission-history', $proposalProcess->slug) }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                            Submission History
                        </a>
                    @endif
                </div>
                
                <!-- Modal body -->
                <div class="p-6 py-4 space-y-4">
                    {{-- alert --}}
                    @if ($count_submission > 3)
                        <div class="flex items-center p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                            <span class="sr-only">Info</span>
                            <div><span class="font-medium">Warning Alert!</span> This student has submitted more than 3 times.</div>
                        </div>
                    @endif

                    {{-- for download requirements --}}
                    <button data-tooltip-target="tooltip-download-requirements" wire:click="exportRequirements({{ $proposalProcess->id }})" class="inline-flex items-center py-2 px-3 text-sm hover:text-blue-700 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2 hover:text-blue-700 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                        Requirements
                    </button>
                    <div id="tooltip-download-requirements" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Download
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    {{-- list --}}
                    <div class="relative overflow-x-auto overflow-y-hidden rounded-lg shadow-sm">
                        @if($submit_proposals->isEmpty())
                            <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                                <div class="block max-w-sm">
                                    <img src="/assets/illustrations/no-data.svg" alt="astronaut image">
                                </div>
                                <div class="text-center xl:max-w-4xl">
                                    <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">Data not found</h1>
                                    <p class="mb-5 text-base font-normal text-gray-500 md:text-lg dark:text-gray-400">Oops! I'm sorry, cannot find the data you're searching for.</p>
                                </div>
                            </div>
                        @else
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            similarity
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Proposal's Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            topic
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            proposal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submit_proposals as $submit_proposal)
                                        @php
                                            $percent = intval($submit_proposal->similarity);
                                            $colorClass = '';
                                    
                                            if ($percent >= 0 && $percent <= 60) {
                                                $colorClass = 'text-green-800';
                                            } elseif ($percent > 65 && $percent <= 85) {
                                                $colorClass = 'text-yellow-800';
                                            } elseif ($percent > 85 && $percent <= 100) {
                                                $colorClass = 'text-red-800';
                                            }
                                        @endphp
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row" class="{{$colorClass}} px-6 py-4 text-2xl whitespace-nowrap dark:text-white">
                                                @if($submit_proposal->similarity === null)
                                                    -
                                                @else
                                                    {{intval($submit_proposal->similarity)}}%
                                                @endif
                                            </th>
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
                                                <a href="{{ route('print.view-pdf', $submit_proposal->proposal)}}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>

                                                {{-- <button data-tooltip-target="tooltip-download-proposal" wire:click="exportProposal({{ $submit_proposal->id }})" class="inline-flex items-center py-2 px-3 text-sm hover:text-blue-700 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    <svg class="w-4 h-4 hover:text-blue-700 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                                                </button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="tooltip-download-proposal" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Download
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button wire:click="showAccept()" data-modal-hide="defaultModal" type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">I accept</button>
                    <button wire:click="showDecline()" data-modal-hide="defaultModal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Decline</button>
                </div>

            </div>
        </div>

        {{-- loading --}}
        <div wire:loading wire:target="showAccept, showDecline" class="@if($showResultSubmit == true) hidden @endif w-full">
            <div class="flex items-center space-x-2 justify-center" role="status">
                <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span>Loading...</span>
            </div>
        </div>
        
        {{-- show form --}}
        <div wire:loading.remove wire:target="showAccept, showDecline" class="@if($showResultSubmit == true) hidden @endif @if($show) bg-white overflow-hidden rounded-lg shadow rounded-lg @else hidden @endif">

            {{-- form --}}
            <div class="m-4">
                <h5 class="text-xl font-bold text-gray-900 dark:text-white">@if($accept) Accept Proposal @else Reject Proposal @endif </h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This feature, can only be used by Coordinator.</p>

                {{-- form --}}
                <form class="mt-4" wire:submit.prevent="submit">
                    
                    @if (!$decline)
                        {{-- proposal that accept --}}
                        <div class="mb-4">
                            <label for="proposal_selected" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chooce Proposal</label>
                            <select id="proposal_selected" name="proposal_selected" wire:model="proposal_selected" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option hidden value="" >Select Proposal</option>
                                @foreach ($submit_proposals as $submit_proposal)
                                    <option value="{{$submit_proposal->id}}">{{$submit_proposal->title}}</option>
                                @endforeach
                            </select>
                            @error('proposal_selected') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    {{-- Desc --}}
                    <div class="mb-4">
                        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                        <textarea id="comment" wire:model="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                        @error('comment') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- button submit --}}
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="text-white @if($accept) bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 @else bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 @endif focus:ring-4 focus:outline-none font-medium rounded-lg text-sm sm:w-auto px-4 py-2 text-center">
                            <span >{{ __('Send') }}</span>
                        </button>
                        @if (session()->has('success'))
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-green-600"
                            >{{ session('success') }}</p>
                        @endif
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

                </form>
            </div>

        </div>

    </div>  
</div>