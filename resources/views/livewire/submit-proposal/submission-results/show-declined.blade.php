<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            <div class="m-4">
                <h5 class="text-lg font-bold text-red-700 dark:text-white">Not Accepted ({{ Illuminate\Support\Carbon::parse($proposalProcess->updated_at)->diffForHumans() }})</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Unfortunately, your proposal for the final assignment was not accepted.</p>

                <div class="p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                        <span class="sr-only">Danger</span>
                        <span class="ml-2 font-bold">Please review the required documents below:</span>
                    </div>
                    <div>
                        <ul class="mt-1.5 mr-2 list-decimal list-inside">
                            <li>Study plan card (for the active semester)</li>
                            <li>Academic transcript</li>
                            <li>Internship report approval sheet</li>
                            <li>Proposal registration form</li>
                            <li>Advisor verification form</li>
                        </ul>
                    </div>
                    <p class="mt-4">
                        <span>Please check the requirements here to review the document completeness.</span>
                        <a href="{{ route('print.view-pdf', $proposalProcess->requirements)}}" target="_blank"class="text-blue-800 dark:text-blue-800 underline font-bold inline-flex items-center">
                            View Requirements 
                            <svg class="ml-2 w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                        </a>
                    </p>
                </div>

                <div class="mt-4 relative overflow-x-auto overflow-y-hidden rounded-lg shadow-sm">
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
                                        Google Scholar similarity
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Uinsu Student Similarity
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Proposal's Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        proposal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submit_proposals as $submit_proposal)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="bg-green-100 text-gray-900 px-6 py-4 text-2xl whitespace-nowrap dark:text-white">
                                            @if($submit_proposal->google_scholar_similarity === null)
                                                <span class="text-xl text-gray-900 font-semibold">[not found]</span>
                                            @else
                                                {{intval($submit_proposal->google_scholar_similarity)}}%
                                            @endif
                                        </th>
                                        <th scope="row" class="bg-green-100 text-gray-900 px-6 py-4 text-2xl whitespace-nowrap dark:text-white">
                                            @if($submit_proposal->uinsu_student_similarity === null)
                                                <span class="text-xl text-gray-900 font-semibold">[not found]</span>
                                            @else
                                                {{intval($submit_proposal->uinsu_student_similarity)}}%
                                            @endif
                                        </th>
                                        <th scope="row" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-light font-semibold text-gray-900">{{ucfirst($submit_proposal->title)}}</div>
                                            <div class="font-normal text-gray-500">
                                                @if($submit_proposal->topic)
                                                    {{$submit_proposal->topic->name}}
                                                @else
                                                    {{$submit_proposal->adding_topic}}
                                                @endif
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('print.view-pdf', $submit_proposal->proposal)}}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
