<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            <div class="m-4">
                <h5 class="text-lg font-medium text-red-700 dark:text-white">Not Accepted ({{ Illuminate\Support\Carbon::parse($proposalProcess->updated_at)->diffForHumans() }})</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Unfortunately, your proposal for the final assignment was not accepted.</p>

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
                <div class="mt-2 relative overflow-x-auto rounded-lg shadow-sm">
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
                                            <button data-tooltip-target="tooltip-download-proposal" wire:click="exportProposal({{ $submit_proposal->id }})" class="inline-flex items-center py-2 px-3 text-sm hover:text-blue-700 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                <svg class="w-4 h-4 hover:text-blue-700 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                                            </button>
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

                <div class="flex justify-end mt-6">
                    {{-- button back --}}
                    <a type="button" href="{{ route("submit-proposal.read") }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Back
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
