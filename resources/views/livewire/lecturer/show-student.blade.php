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

                {{-- table --}}
                <div class="m-4 relative overflow-x-auto rounded-lg shadow-sm overflow-y-hidden">
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
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4"></th>
                                    <th scope="col" class="px-6 py-3">
                                        Student
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Year
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Topic
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $proposals as $index => $proposal )
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th class="px-4 py-3 font-medium text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $proposals->firstItem() + $index }}
                                        </th>
                                        <th class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-light font-semibold text-gray-900">{{ $proposal->name }}</div>
                                            <div class="font-normal text-gray-500">{{ $proposal->nim }}</div>
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $proposal->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($proposal->status == 'done')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Done</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">OnProcess</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $proposal->year }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($proposal->topic )
                                                {{ $proposal->topic->name }}
                                            @else
                                                {{ $proposal->adding_topic }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($proposal->type == 'thesis')
                                                <p class="flex justify-center bg-green-100 text-green-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Thesis</p>
                                            @elseif($proposal->type == 'appropriate_technology')
                                                <p class="flex justify-center bg-purple-100 text-purple-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Appropriate_Technology</p>
                                            @elseif($proposal->type == 'journal')
                                                <p class="flex justify-center bg-yellow-100 text-yellow-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Journal</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Edit
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Delete
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    @endif
                </div>

                {{-- table footer --}}
                <div class="m-4">
                    {{ $proposals->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
