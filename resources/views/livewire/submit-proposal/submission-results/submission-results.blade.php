<div>
    <div class="m-4">
        @if(!isset($proposalProcess->comment) && $proposal_onProcess->isEmpty())
            <div class="mt-4">
                <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                    <div class="block max-w-sm flex justify-center">
                        <img src="/assets/illustrations/waiting3.svg" alt="astronaut image" width="70%">
                    </div>
                    <div class="text-center xl:max-w-4xl mt-5">
                        <h1 class="mb-2 text-lg font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">🔍 Awaits Confirmation</h1>
                        <p class="text-base font-normal text-gray-600 dark:text-gray-400">You're eagerly awaiting the results of your submitted proposal. Stay tuned for updates!</p>
                    </div>
                </div>  
            </div>         
        @else
            <div class="mt-4">
                <h5 class="text-lg font-bold text-gray-900 dark:text-white">Proposal Acceptance Updates</h5>
                <p class="mt-1 text-gray-500 dark:text-gray-400 font-normal text-sm">This section displays updates on the acceptance of submitted proposals.</p>
                
                {{-- alert --}}
                <div class="flex mt-1 items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                    <span class="sr-only">Info</span>
                    <div><span class="font-medium">You have only three chances to submit your proposal, so make them count!.</span></div>
                </div>

                <div class="mt-6 ml-6">
                    <ol class="relative border-l border-gray-200 dark:border-gray-700">
                        @foreach ($proposals_process as $index => $proposal_process)
                            <li class="mb-6 mx-6">
                                <div class="absolute flex items-center justify-center w-8 h-8 bg-red-100 rounded-full -left-4 ring-8 ring-white dark:ring-gray-900 dark:bg-red-900">
                                    <span class="font-semibold">{{++$index}}X</span>
                                </div>
                                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                    <div class="items-center justify-between mb-3 sm:flex">
                                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                            {{ Illuminate\Support\Carbon::parse($proposal_process->updated_at)->diffForHumans() }}
                                        </time>
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                            <span class="font-semibold text-gray-900 dark:text-white hover:underline">Unfortunately, your proposal was not accepted.</span>
                                            @if($loop->last)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-normal mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Latest</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2 p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                        {{$proposal_process->comment}}
                                    </div>
                                    <div class="flex justify-end">
                                        <a href="{{ route('submit-proposal.show-declined', $proposal_process->slug) }}" class="block text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Read more</a>
                                    </div>                        
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="flex justify-end">
                    <button type="button" wire:click="resubmit()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Resubmit
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
