<div>
    <div class="m-4">
        @if(!isset($proposalProcess->explanation))
            <div class="mt-4">
                <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                    <div class="block max-w-sm flex justify-center">
                        <img src="/assets/illustrations/waiting3.svg" alt="astronaut image" width="70%">
                    </div>
                    <div class="text-center xl:max-w-4xl mt-5">
                        <h1 class="mb-2 text-xl font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">🔍 Awaits Confirmation</h1>
                        <p class="text-base font-normal text-gray-600 dark:text-gray-400">You're eagerly awaiting the results of your submitted proposal. Stay tuned for updates!</p>
                    </div>
                </div>  
            </div>         
        @else
            <div class="mt-4">
                <h5 class="text-sm font-medium text-gray-900 dark:text-white">Proposal Acceptance Updates</h5>
                <p class="mt-1 text-gray-500 dark:text-gray-400 font-normal text-sm">This section displays updates on the acceptance of submitted proposals. You have only three chances to submit your proposal, so make them count!.</p>
                    
                <div class="mt-6 ml-6">
                    <ol class="relative border-l border-gray-200 dark:border-gray-700">
                        @foreach ($proposals_process as $proposal_process)
                            <li class="mb-6 mx-6">
                                <div class="absolute flex items-center justify-center w-8 h-8 bg-red-100 rounded-full -left-4 ring-8 ring-white dark:ring-gray-900 dark:bg-red-900">
                                    <svg class="w-4 h-4 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v2H7V2ZM5 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm8 4H8a1 1 0 0 1 0-2h5a1 1 0 0 1 0 2Zm0-4H8a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Z"/>
                                    </svg>
                                </div>
                                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                    <div class="items-center justify-between mb-3 sm:flex">
                                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                            {{ Illuminate\Support\Carbon::parse($proposal_process->date)->diffForHumans() }}
                                        </time>
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                            <span class="font-semibold text-gray-900 dark:text-white hover:underline">Unfortunately, your proposal was not accepted.</span>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-normal mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Latest</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                        {{$proposal_process->explanation}}
                                    </div>
                                    <div class="flex justify-end">
                                        <a href="{{ route('submit-proposal.read') }}" class="block text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Read more</a>
                                    </div>                        
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="flex justify-end">
                    <button type="button" wire:click="resubmit()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Resubmit
                    </button>
                </div>
            </div>
        
        
            {{-- <div class="mt-4"> --}}
                {{-- <h5 class="text-xl font-medium text-gray-900 dark:text-white">Result of proposal accepted</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">The results of proposals that have been submitted will be displayed here. Results may take one to 2 weeks.</p>
                 --}}
                {{-- table submit proposal--}}
                {{-- <div class="mt-4 relative overflow-x-auto rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
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
                                    Desc
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submit_proposals as $submit_proposal)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        @if($submit_proposal->acc_coordinator == 1)
                                            <svg class="w-6 h-6 text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                                        @else
                                            <svg class="w-6 h-6 text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>
                                        @endif
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$submit_proposal->title}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$submit_proposal->topic->name}}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($submit_proposal->similarity === null)
                                            -
                                        @else
                                            {{$submit_proposal->similarity}}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="export({{ $submit_proposal->id }})" class="inline-flex items-center py-2 px-3 text-sm hover:text-blue-700 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 hover:text-blue-700 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4">
                                    {{ $submit_proposal->desc_coordinator }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}

                {{-- table lecturers--}}
                {{-- <div class="m-4 relative overflow-x-auto rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4"></th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gender
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $lecturers as $index => $lecturer )
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th class="px-4 py-3 font-medium text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $lecturers->firstItem() + $index }}
                                    </th>
                                    <th class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if($lecturer->user->avatar)
                                            <img class="object-cover w-10 h-10 rounded-full" src="{{ asset('storage/avatars/'.$lecturer->user->avatar) }}" alt="avatar"/>
                                        @else                    
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($lecturer->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="40">
                                        @endif
                                        <div class="px-6">
                                            <div class="text-light font-semibold text-gray-900">{{ $lecturer->user->name }}</div>
                                            <div class="font-normal text-gray-500">{{ $lecturer->nip }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        @if($lecturer->user->gender == 'male')
                                            <p class="flex items-center text-xs font-medium text-gray-900 dark:text-white">
                                                <span class="flex w-2.5 h-2.5 bg-blue-600 rounded-full mr-1.5 flex-shrink-0"></span>
                                                Male
                                            </p>
                                        @else
                                            <p class="flex items-center text-xs font-medium text-gray-900 dark:text-white">
                                                <span class="flex w-2.5 h-2.5 bg-red-300 rounded-full mr-1.5 flex-shrink-0"></span>
                                                Female
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecturer->user->phone }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($lecturer->students)
                                            <a wire:click="showStudents({{ $lecturer->id }})" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-students-show')" href="" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                                                {{ $lecturer->students->count()}} students
                                            </a>
                                        @endif
                                    </td>
                                        @if (auth()->user()->hasRole('coordinator'))
                                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                                            <a href="" wire:click="editIdLecturer({{ $lecturer->id }})" wire:click.prevent class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-300 dark:hover:bg-yellow-300 dark:focus:ring-yellow-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                            </a>
                                            <a href="" wire:click="deleteIdLecturer({{ $lecturer->id }})" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-lecturer-deletion')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
            {{-- </div> --}}
        @endif
    </div>
</div>
