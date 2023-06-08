<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">

            <form class="m-4">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Check Similarity of Title</h5>
                <p class="mt-1 mb-4 text-gray-500 dark:text-gray-400 font-normal text-sm">The data that will be compared are taken from the titles of the final assignment by Information Systems Student UINSU Medan and Google Scholar.</p>
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative mb-4">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input  wire:model="text" type="search" id="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                    <button wire:click="checkSimilarities" wire:click.prevent type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
                @error('text') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
            </form>

            <div class="m-4 overflow-hidden">
                {{-- loading --}}
                <div wire:loading wire:target="checkSimilarities" class="w-full">
                    <div class="flex items-center space-x-2 justify-center" role="status">
                        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>
                    </div>
                </div>

                {{-- result --}}
                @if (count($similarities) > 0)
                    <h5 class="text-xl font-medium text-gray-900 dark:text-white">The Result</h5>
                    <p class="my-1 items-center  text-gray-500 dark:text-gray-400 font-normal text-sm">Show your result for the next step: submit a proposal. This result can be read by lecturers for proposal submission process.</p>
                    <div class="flex">
                        <button type="button" class="inline-flex items-center justify-center text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 mt-1 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 mb-6">
                            <svg class="w-6 h-6 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                            </svg>
                            Next to Submitting Proposal
                        </button>
                        <h5 class="inline-flex items-center mx-4 mb-4 text-2xl font-bold text-gray-700 dark:text-white">{{ $first_percent }}%</h5>
                    </div>
                    @foreach($similarities as $similarity)
                        @php
                            $percent = $similarity['percent'];
                            $colorClass = '';
                    
                            if ($percent >= 0 && $percent <= 30) {
                                $colorClass = 'bg-green-50 border-green-300 text-green-800';
                            } elseif ($percent > 30 && $percent <= 60) {
                                $colorClass = 'bg-yellow-50 border-yellow-300 text-yellow-800';
                            } elseif ($percent > 60 && $percent <= 100) {
                                $colorClass = 'bg-red-50 border-red-300 text-red-800';
                            }
                        @endphp
                        <div class="overflow-x-auto flex justify-between p-2 mb-4 text-sm border rounded-lg {{ $colorClass }} dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                            <span class="font-medium inline-flex items-center">{{ $similarity['title'] }}</span>
                            <div class="flex justify-between">
                                <span class="font-medium inline-flex items-center pl-3"> ({{ $similarity['percent'] }}%)</span>
                                <button data-popover-target="popover-user-profile" type="button" class="inline-flex items-center text-gray-500 focus:outline-none font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>                                                                       
                                </button>
                                <div data-popover id="popover-user-profile" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                    <div class="p-3">
                                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                            <a href="#">{{ $similarity['name']}} ({{ $similarity['year'] }})</a>
                                        </p>
                                        <p class="mb-3 text-sm font-normal">
                                            {{ $similarity['nim'] }}
                                        </p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                        @if ($similarity == 10) @break @endif
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>
