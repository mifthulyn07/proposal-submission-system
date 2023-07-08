@push('styles')
    <style>
        p.text-sm.text-gray-700.leading-5 {
            display: none;
        }
    </style>
@endpush

<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">

            {{-- alert --}}
            <div class="m-4 ">
                @if (session()->has('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="alert-remove p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" 
                        role="alert"
                    >{{ session('success') }}</div>
                @endif

                @if (session()->has('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="alert-remove p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" 
                        role="alert"
                    >{{ session('error') }}</div>
                @endif
            </div>

            {{-- table header --}}
            <div class="m-4 flex items-center justify-between bg-white dark:bg-gray-900">
                {{-- button --}}
                <div class="mr-2">
                    <a href="{{ Route('student.create') }}" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add</a>
                </div>
                {{-- search --}}
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative ml-2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input wire:model='search' type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for student">
                </div>
            </div>

            {{-- table --}}
            <div class="m-4 relative overflow-x-auto rounded-lg">
                @if($students->isEmpty())
                    <div class="m-4">
                        <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                            <div class="block max-w-sm">
                                <img src="/assets/illustrations/no-data.svg" alt="astronaut image">
                            </div>
                            <div class="text-center xl:max-w-4xl">
                                <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">Data not found</h1>
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
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    NIM
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gender
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Class
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Dosen PA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $students as $index => $student )
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th class="px-4 py-3 font-medium text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $students->firstItem() + $index }}
                                    </th>
                                    <th scope="row" class="px-6 py-4">
                                        <div class="text-light font-semibold text-gray-900">{{ $student->user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $student->user->email }}</div>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $student->nim }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($student->user->gender == 'male')
                                            <span class="flex items-center text-xs font-medium text-gray-900 dark:text-white"><span class="flex w-2.5 h-2.5 bg-blue-600 rounded-full mr-1.5 flex-shrink-0"></span>Male</span>
                                        @else
                                            <span class="flex items-center text-xs font-medium text-gray-900 dark:text-white"><span class="flex w-2.5 h-2.5 bg-red-300 rounded-full mr-1.5 flex-shrink-0"></span>Female</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $student->user->phone }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $student->class }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($student->dosen_pa)
                                            {{ $student->dosen_pa->user->name }}
                                        @endif
                                    </td>
                                    <td class="p-4 flex justify-center whitespace-nowrap">
                                        <a wire:click="editIdLecturer({{ $student->id }})" wire:click.prevent class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-300 dark:hover:bg-yellow-300 dark:focus:ring-yellow-300">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- table footer --}}
            <div class="m-4">
                {{ $students->links() }}
            </div>

        </div>
    </div>
</div>
