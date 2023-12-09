<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">
            
            <div class="w-full p-4 bg-white dark:bg-gray-800 dark:border-gray-700">
                <h5 class="text-lg font-medium text-gray-900 dark:text-white">Student Project Results</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Explore student project results. This page provides insights into the progress and outcomes of the projects supervised by various lecturers.</p>
                
                {{-- table header --}}
                <div class="mt-4">
                    <div class="relative bg-white dark:bg-gray-800 rounded-lg">
                        <div class="flex flex-col items-center justify-between space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                            
                            {{-- search  --}}
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

                <div class="mt-4 grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700">
                    @if($proposals->isEmpty())
                        <div class="m-4">
                            <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                                <div class="block max-w-sm">
                                    <img src="/assets/illustrations/no-data.svg" alt="astronaut image">
                                </div>
                                <div class="text-center xl:max-w-4xl">
                                    <h1 class="mb-3 text-xl font-bold leading-tight text-gray-900 sm:text-2xl dark:text-white">Data not found</h1>
                                    <p class="mb-5 text-base font-normal text-gray-500 md:text-lg dark:text-gray-400">Oops! I'm sorry, cannot find the data you're searching for.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($proposals as $proposal)
                            <figure class="flex flex-col items-center justify-center p-4 text-center bg-white border-b border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                                <blockquote class="max-w-2xl mx-auto mb-2 text-gray-500 lg:mb-8 dark:text-gray-400">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{$proposal->year}} | 
                                        @if($proposal->status == 'Done')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Done</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">OnProcess</span>
                                        @endif
                                    </h3>
                                    <p class="my-4">
                                        <span class="font-semibold">"{{ $proposal->title }}"</span> 
                                        with topic 
                                        <span class="font-semibold">@if($proposal->topic) {{ $proposal->topic->name }} @else {{$proposal->adding_topic}} @endif </span>
                                    </p>
                                </blockquote>
                                <figcaption class="flex items-center justify-center space-x-3">
                                    <button data-popover-target="popover-company-profile-{{$proposal->id}}">
                                        @if($proposal->student->user->avatar)
                                            <div class="inline-block w-10 h-10 overflow-hidden bg-gray-300 rounded-full">
                                                <img class="object-cover w-10 h-10" src="{{ asset('storage/avatars/'.$proposal->student->user->avatar) }}" alt="avatar"/>
                                            </div>
                                        @else                    
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($proposal->student->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="40">
                                        @endif
                                    </button>

                                    <div class="space-y-0.5 font-medium dark:text-white text-left">
                                        <div>{{ $proposal->student->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            @if($proposal->type == 'thesis')
                                                <p class="flex justify-center bg-green-100 text-green-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Thesis</p>
                                            @elseif($proposal->type == 'appropriate_technology')
                                                <p class="flex justify-center bg-purple-100 text-purple-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Appropriate_Technology</p>
                                            @elseif($proposal->type == 'journal')
                                                <p class="flex justify-center bg-yellow-100 text-yellow-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Journal</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- popup detail profile--}}
                                    <div data-popover id="popover-company-profile-{{$proposal->id}}" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-80 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                        <div class="p-3">
                                            <div class="flex">
                                                <div class="mr-3 shrink-0">
                                                    <div href="#" class="block p-2 bg-gray-100 rounded-lg dark:bg-gray-700">
                                                        @if($proposal->student->user->avatar)
                                                            <img class="object-cover w-10 h-10 rounded-full" src="{{ asset('storage/avatars/'.$proposal->student->user->avatar) }}" alt="avatar"/>
                                                        @else
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($proposal->student->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="38">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="mb-1 text-base font-semibold leading-none text-gray-900 dark:text-white">
                                                        {{ $proposal->student->user->name }}
                                                    </p>
                                                    <p class="mb-3 text-sm font-normal">
                                                        {{ $proposal->student->user->email }}
                                                    </p>
                                                    <ul class="mb-3 space-y-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <li class="flex items-center">
                                                            <svg class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/></svg>
                                                            <div  role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                Gender
                                                            </div>
                                                            @if($proposal->student->user)
                                                                {{ $proposal->student->user->gender }}
                                                            @endif
                                                        </li>
                                                        <li class="flex items-center">
                                                            <svg class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18"><path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z"/></svg>
                                                            <div role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                Phone
                                                            </div>
                                                            @if($proposal->student->user)
                                                                {{ $proposal->student->user->phone }}
                                                            @endif
                                                        </li>
                                                        <li class="flex items-center">
                                                            <svg class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/><path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/></svg>
                                                            <div role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                Class
                                                            </div>
                                                            @if($proposal->student)
                                                                {{ $proposal->student->class }}
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>

                                </figcaption>    
                            </figure>
                        @endforeach
                    @endif
                </div>

                {{-- table footer --}}
                <div class="mt-4">
                    {{ $proposals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
