<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            <div class="m-4 mb-4">
                <h5 class="text-lg font-medium text-gray-900 dark:text-white">Title Similarity Check</h5>
                <p class="mt-1 mb-4 text-gray-500 dark:text-gray-400 font-normal text-sm">We'll compare your title with final assignment titles from UINSU Medan's Information Systems students and Google Scholar.</p>
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                {{-- form  --}}                
                <form wire:submit.prevent="checkSimilarities">
                    <label for="chat" class="sr-only">Check Similarity</label>
                    <div class="flex items-center px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 shadow-sm">
                        <textarea id="chat" wire:model.defer="text" rows="1" class="block mr-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Let's check your title here!"></textarea>
                        <button type="submit" class="text-white items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Check</button>
                    </div>
                    @error('text') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                </form>
            </div>

            {{-- loading --}}
            <div class="m-4">
                <div wire:loading wire:target="checkSimilarities" class="w-full">
                    <div class="flex items-center space-x-2 justify-center" role="status">
                        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>
                    </div>
                </div>
            </div>

            {{-- result --}}
            @if (count($similarities) > 0)
                <div class="m-4">
                    @if(isset($proposalProcess))
                        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Your Result</h5>
                        <p class="my-1 items-center  text-gray-500 dark:text-gray-400 font-normal text-sm">See your result for proposal submission. It's considered by lecturers for acceptance.</p>
                        @if (auth()->user()->hasRole('student'))
                            <a href="{{ route('submit-proposal-2.create', ['proposalProcess' => $proposalProcess->id, 'title' => $text, 'similarity' => $result_cosim]) }}" type="button" wire:click="proposalSubmit()" class="my-2 inline-flex items-center justify-center text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <svg class="w-6 h-6 mr-2 -ml-1 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18.017 15.002h-1.5v-1.5a1 1 0 0 0-2 0v1.5h-1.5a1 1 0 0 0 0 2h1.5v1.5a1 1 0 1 0 2 0v-1.5h1.5a1 1 0 1 0 0-2Z"/><path d="m17.74 4.758-7.476 8.409a1 1 0 0 1-.718.335h-.029a1 1 0 0 1-.707-.293l-4-4a1 1 0 0 1 1.414-1.413l3.25 3.25L16.53 3.11a9.5 9.5 0 1 0-3.885 15.355 2.495 2.495 0 0 1 .373-4.963 2.5 2.5 0 0 1 5 0c.035 0 .068.01.1.01a9.43 9.43 0 0 0-.38-8.754h.002Z"/></svg>
                                Next to Submitting Proposal
                            </a>
                            <h5 class="inline-flex items-center mx-4 mb-4 text-2xl font-bold text-gray-700 dark:text-white">{{ $result_cosim }}% Similarity</h5>
                        @endif
                    @endif
                    <div class="relative overflow-x-auto rounded-lg shadow-sm">
                        <table class="rounded-lg w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="rounded-lg text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Similarity
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Summary
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nim
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Year/Link
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($similarities as $key => $similarity)
                                    @php
                                        $percent = intval($similarity->cosim);
                                        $colorClass = '';
                                
                                        if ($percent >= 0 && $percent <= 60) {
                                            $colorClass = 'text-green-800';
                                        } elseif ($percent > 65 && $percent <= 85) {
                                            $colorClass = 'text-yellow-800';
                                        } elseif ($percent > 85 && $percent <= 100) {
                                            $colorClass = 'text-red-800';
                                        }
                                    @endphp
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="{{$colorClass}} px-6 py-4 text-2xl whitespace-nowrap dark:text-white">
                                            {{intval($similarity->cosim)}}%
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-light font-semibold text-gray-900">{{$similarity->title}}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$similarity->name_summary}}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if(is_numeric($similarity->nim_uniquecode))
                                                {{$similarity->nim_uniquecode}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if(is_numeric($similarity->year_link))
                                                {{$similarity->year_link}}
                                            @else
                                                <a href="{{$similarity->year_link}}" target="_blank" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Open link</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($key == 19) @break @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($null_similarity)
                <div class="m-4">
                    @if(isset($proposalProcess))
                        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Your Result</h5>
                        <p class="my-1 items-center  text-gray-500 dark:text-gray-400 font-normal text-sm">See your result for proposal submission. It's considered by lecturers for acceptance.</p>
                        @if (auth()->user()->hasRole('student'))
                            <a href="{{ route('submit-proposal-2.create', ['proposalProcess' => $proposalProcess->id, 'title' => $text, 'similarity' => $result_cosim]) }}" type="button" wire:click="proposalSubmit()" class="my-2 inline-flex items-center justify-center text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <svg class="w-6 h-6 mr-2 -ml-1 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18.017 15.002h-1.5v-1.5a1 1 0 0 0-2 0v1.5h-1.5a1 1 0 0 0 0 2h1.5v1.5a1 1 0 1 0 2 0v-1.5h1.5a1 1 0 1 0 0-2Z"/><path d="m17.74 4.758-7.476 8.409a1 1 0 0 1-.718.335h-.029a1 1 0 0 1-.707-.293l-4-4a1 1 0 0 1 1.414-1.413l3.25 3.25L16.53 3.11a9.5 9.5 0 1 0-3.885 15.355 2.495 2.495 0 0 1 .373-4.963 2.5 2.5 0 0 1 5 0c.035 0 .068.01.1.01a9.43 9.43 0 0 0-.38-8.754h.002Z"/></svg>
                                Next to Submitting Proposal
                            </a>
                            <h5 class="inline-flex items-center mx-4 mb-4 text-2xl font-bold text-gray-700 dark:text-white">{{ $result_cosim }}% Similarity</h5>
                        @endif
                    @endif
                    <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                        <div class="block max-w-sm">
                            <img src="/assets/illustrations/waiting0.svg" alt="light bulb image">
                        </div>
                        <div class="mt-2 text-center xl:max-w-4xl">
                            <h1 class="mb-3 text-base font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">💡 No Matching Articles Found</h1>
                            <p class="text-sm font-normal text-gray-600 dark:text-gray-400">It seems there are no articles that match your search criteria. Get inspired and explore new ideas!</p>
                        </div>
                    </div>
                </div>
            @else
                {{-- image --}}
                <div class="m-4">
                    <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                        <div class="block max-w-sm">
                            <img src="/assets/illustrations/saly1.svg" alt="light bulb image">
                        </div>
                        <div class="text-center xl:max-w-4xl">
                            <h1 class="mb-3 text-base font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">💡 Spark Your Creativity!</h1>
                            <p class="text-base font-sm text-gray-600 dark:text-gray-400">Get inspired and ensure your proposal shines by checking its similarity with others. Unleash your unique ideas!</p>
                        </div>
                    </div>
                </div>                   
            @endif

        </div>
    </div>
</div>
