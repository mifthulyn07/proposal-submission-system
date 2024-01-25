<div>
    <div class="mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative items-center block bg-white overflow-hidden shadow rounded-lg">
                
                <div class="m-4">
                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">Submission History</h5>
                    <p class="mt-1 text-gray-500 dark:text-gray-400 font-normal text-sm">This section displays updates on the acceptance of submitted proposals.</p>
                        
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
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="flex justify-end mt-6">
                        {{-- button back --}}
                        <a type="button" href="{{ route("check-proposal.check", $proposalProcess->slug) }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
