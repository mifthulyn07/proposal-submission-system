<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">
            {{-- alert --}}
            <div class="m-4 ">
                @if (session()->has('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        class="alert-remove p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" 
                        role="alert"
                    >{{ session('success') }}</div>
                @endif

                @if (session()->has('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        class="alert-remove p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" 
                        role="alert"
                    >{{ session('error') }}</div>
                @endif
            </div>

            {{-- input--}}                
            <div class="m-4 mb-4">
                <h5 class="text-lg font-bold text-gray-900 dark:text-white">Check Title Similarity</h5>
                <p class="mt-1 mb-4 text-gray-500 dark:text-gray-400 font-normal text-sm">We'll compare your title with final assignment titles from UINSU Medan's Information Systems students and Google Scholar.</p>
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                
                <label for="chat" class="sr-only">Check Similarity</label>
                <div class="flex justify-center px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 shadow-sm">
                    <div class="w-full mr-4">
                        <textarea id="text" wire:loading.attr="disabled" wire:target="checkSimilarities" wire:model="text" rows="1" @if($isSimilarityChecked == true) disabled aria-label="disabled input" @endif class="bg-white block w-full p-2.5 text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Let's check your title here!"></textarea>
                        @error('text') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <button type="button" @if($isSimilarityChecked == true) wire:click="recheck()" @else wire:click="checkSimilarities()" @endif wire:loading.attr="disabled" wire:loading.class="bg-blue-800" wire:target="checkSimilarities" class="@if($isSimilarityChecked == true) bg-gray-700 hover:bg-gray-800 focus:ring-gray-300 @else bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 @endif text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-6 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            @if($isSimilarityChecked == true)
                                Recheck
                            @else
                                Check 
                            @endif
                        </button>
                    </div>
                </div>
            </div>

            {{-- result --}}
            <div class="m-4">
                {{-- loading --}}
                <div wire:loading wire:target="checkSimilarities" class="w-full mb-17">
                    <div class="flex items-center space-x-2 justify-center" role="status">
                        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>
                    </div>
                </div>

                {{-- result  --}}
                <div wire:loading.remove wire:target="checkSimilarities">
                    @if(count($similaritiesForUinsuStudent) > 0 || $notFoundForGoogleScholar && count($similaritiesForGoogleScholar) > 0 || $notFoundForGoogleScholar)
                            {{-- caption --}}
                            <div class="mb-2 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                <h5 class="text-lg font-bold text-gray-900 dark:text-white">Your Proposal's Similarity Score</h5>
                                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">The similarity score of your proposal title is a key factor considered by the coordinator for approval.</p>
                            </div>

                            @if(isset($proposalProcess))
                                @if (auth()->user()->hasRole('student'))
                                    {{-- button --}}
                                    <button wire:click="submitProposal()" wire:click.prevent class="mb-2 w-full inline-flex items-center justify-center text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        <svg class="w-6 h-6 mr-2 -ml-1 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18.017 15.002h-1.5v-1.5a1 1 0 0 0-2 0v1.5h-1.5a1 1 0 0 0 0 2h1.5v1.5a1 1 0 1 0 2 0v-1.5h1.5a1 1 0 1 0 0-2Z"/><path d="m17.74 4.758-7.476 8.409a1 1 0 0 1-.718.335h-.029a1 1 0 0 1-.707-.293l-4-4a1 1 0 0 1 1.414-1.413l3.25 3.25L16.53 3.11a9.5 9.5 0 1 0-3.885 15.355 2.495 2.495 0 0 1 .373-4.963 2.5 2.5 0 0 1 5 0c.035 0 .068.01.1.01a9.43 9.43 0 0 0-.38-8.754h.002Z"/></svg>
                                        Next to Submitting Proposal
                                    </button>
                                @endif
                            @endif

                            {{-- show result similarity --}}
                            <div class="grid md:grid-cols-2 gap-4 mb-7">
                                <div class="bg-blue-100 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded-lg p-4 md:p-6">
                                    <blockquote class="flex flex-col justify-center items-center max-w-2xl mx-auto text-gray-500 dark:text-gray-400">
                                        <div class="flex items-baseline text-gray-900 dark:text-white">
                                            @if($highestScoreCosimGoogleScholar === null)
                                                <span class="text-3xl text-gray-900 font-semibold">[not found]</span>
                                            @else
                                                <span class="text-5xl font-extrabold text-gray-900 tracking-tight">{{ $highestScoreCosimGoogleScholar }}</span>
                                                <span class="text-3xl text-gray-900 font-semibold">%</span>
                                            @endif
                                        </div>
                                        <dd class="text-gray-500 dark:text-gray-400">Google Scholar Similarity</dd>
                                    </blockquote>
                                </div>
                                <div class="bg-blue-100 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded-lg p-4 md:p-6">
                                    <blockquote class="flex flex-col justify-center items-center max-w-2xl mx-auto text-gray-500 dark:text-gray-400">
                                        <div class="flex items-baseline text-gray-900 dark:text-white">
                                            @if($highestScoreCosimUinsuStudent === null)
                                                <span class="text-3xl text-gray-900 font-semibold">[not found]</span>
                                            @else
                                                <span class="text-5xl font-extrabold text-gray-900 tracking-tight">{{ $highestScoreCosimUinsuStudent }}</span>
                                                <span class="text-3xl text-gray-900 font-semibold">%</span>
                                            @endif
                                        </div>
                                        <dd class="text-gray-500 dark:text-gray-400">UIN-SU Student Similarity</dd>
                                    </blockquote>
                                </div>
                            </div>

                        {{-- hasil dari google scholar  --}}
                        @if (count($similaritiesForGoogleScholar) > 0)
                            <div class="mb-7">
                                {{-- caption --}}
                                <div class="mb-2 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">Analyzing Results from Google Scholar</h5>
                                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Quantitatively analyzing title structures using advanced cosine similarity and TF-IDF algorithms, providing valuable insights into the relationship with titles on Google Scholar.</p>
                                </div>   
                                
                                {{-- info --}}
                                <div class="mb-4">
                                    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-bold">Info alert!</span> Only the top 10 results are displayed.
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- table --}}
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
                                                    Details
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($similaritiesForGoogleScholar as $key => $similarity)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row" class="bg-green-100 px-6 py-4 text-2xl whitespace-nowrap dark:text-white">
                                                        {{intval($similarity->cosim)}}%
                                                    </th>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-light font-semibold text-gray-900">{{$similarity->title}}</div>
                                                        <div class="font-normal text-gray-600">{{ $similarity->summary }}</div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <a href="{{ $similarity->link }}" target="_blank" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Explore</a>
                                                    </td>
                                                </tr>
                                                @if ($key == 9) @break @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="mb-7">
                                {{-- caption --}}
                                <div class="mb-4 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">Analyzing Results from Google Scholar</h5>
                                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Quantitatively analyzing title structures using advanced cosine similarity and TF-IDF algorithms, providing valuable insights into the relationship with titles on Google Scholar.</p>
                                </div>
                                
                                {{-- result image --}}
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
                        @endif
                        
                        {{-- hasil dari uinsu student --}}
                        @if (count($similaritiesForUinsuStudent) > 0)
                            <div class="mb-7">
                                {{-- caption --}}
                                <div class="mb-4 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">Analyzing Results from UINSU Information Systems Students</h5>
                                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Quantitatively analyzing title structures of UINSU Information Systems students using advanced cosine similarity and TF-IDF algorithms, providing valuable insights into the relationships found within their titles.</p>
                                </div>

                                {{-- info --}}
                                <div class="mb-4">
                                    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-bold">Info alert!</span> Only the top 10 results are displayed.
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- table --}}
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($similaritiesForUinsuStudent as $key => $similarity)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-4 text-2xl whitespace-nowrap dark:text-white bg-green-100">
                                                        {{intval($similarity->cosim)}}%
                                                    </th>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-light font-semibold text-gray-900">{{$similarity->title}}</div>
                                                        <div class="font-normal text-gray-600">{{$similarity->name}} ({{($similarity->year)}})</div>
                                                    </td>
                                                </tr>
                                                @if ($key == 19) @break @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div>
                                {{-- caption --}}
                                <div class="mb-4 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-white">Analyzing Results from UINSU Information Systems Students</h5>
                                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Quantitatively analyzing title structures of UINSU Information Systems students using advanced cosine similarity and TF-IDF algorithms, providing valuable insights into the relationships found within their titles.</p>
                                </div>

                                {{-- result image --}}
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
                        @endif
                    @else
                        <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                            <div class="block max-w-sm">
                                <img src="/assets/illustrations/saly1.svg" alt="light bulb image">
                            </div>
                            <div class="text-center xl:max-w-4xl">
                                <h1 class="mb-3 text-base font-bold leading-tight text-indigo-700 sm:text-4xl lg:text-5xl dark:text-purple-500">💡 Spark Your Creativity!</h1>
                                <p class="text-base font-sm text-gray-600 dark:text-gray-400">Get inspired and ensure your proposal shines by checking its similarity with others. Unleash your unique ideas!</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>                   

        </div>
    </div>
</div>
