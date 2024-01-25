<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">
            <article class="m-4 lg:gap-8 md:grid lg:grid-cols-3">
                {{-- profile --}}
                <div>
                    {{-- avatar --}}
                    <div class="flex items-center mb-6 space-x-4">
                        @if($proposal->student->user->avatar)
                            <img class="object-cover w-12 h-12 rounded-full" src="{{ asset('storage/avatars/'.$proposal->student->user->avatar) }}" alt="avatar"/>
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($proposal->student->user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="50">
                        @endif
                        <div class="space-y-1 font-medium dark:text-white">
                            <p class="font-bold">{{ $proposal->name }}</p>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                {{ $proposal->nim }}
                            </div>
                        </div>
                    </div>

                    {{-- profile --}}
                    <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                        <li class="flex items-center">
                            <svg data-tooltip-target="tooltip-gender" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/></svg>
                            <div id="tooltip-gender" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Profil <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            @if($proposal->student->user)
                                {{ $proposal->student->user->email }} | {{ $proposal->student->user->gender }}
                            @endif
                        </li>
                        <li class="flex items-center">
                            <svg data-tooltip-target="tooltip-phone" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18"><path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z"/></svg>
                            <div id="tooltip-phone" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Phone <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            @if($proposal->student->user)
                            Indonesia - {{ $proposal->student->user->phone }}
                            @endif
                        </li>
                        <li class="flex items-center">
                            <svg data-tooltip-target="tooltip-class" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/><path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/></svg>
                            <div id="tooltip-class" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Class <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            @if($proposal->student)
                                {{ $proposal->student->class }}
                            @endif
                        </li>
                        <li class="flex items-center">
                            <svg data-tooltip-target="tooltip-supervisor" class="w-3 h-3 mr-2 text-gray-550 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 18"><path d="M7 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm2 1H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/></svg>
                            <div id="tooltip-supervisor" role="tooltip" class="absolute z-10 left-0 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Supervisor <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            @if($proposal->student->lecturer)
                                {{ $proposal->student->lecturer->user->name }} | {{$proposal->student->lecturer->user->gender}}
                            @endif
                        </li>
                    </ul>
                </div>

                {{-- assignment advisor --}}
                <div class="col-span-2 mt-6 lg:mt-0">
                    <div class="flex items-start mb-5">
                        <div class="pr-4">
                            <footer>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    Reviewed: <time>{{ Illuminate\Support\Carbon::parse($proposal->updated_at)->diffForHumans() }}</time>
                                </p>
                            </footer>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $proposal->title }}</h4>
                        </div>
                    </div>
                    <p class="mb-2 text-gray-500 dark:text-gray-400">
                        Comment from coordinator:
                        @if ($proposal->comment)
                            {{ $proposal->comment }}                            
                        @else
                            -
                        @endif
                    </p>
                    <aside>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Type of proposal: 
                            @if($proposal->type == 'thesis')
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-0.5 mb-1 p-1 rounded dark:bg-green-900 dark:text-green-300">Thesis</span>
                            @elseif($proposal->type == 'appropriate_technology')
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-0.5 mb-1 p-1 rounded dark:bg-purple-900 dark:text-purple-300">Appropriate Technology</span>
                            @elseif($proposal->type == 'journal')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-0.5 mb-1 p-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Journal</span>
                            @endif
                        </p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Topic: 
                            @if($proposal->topic)
                                {{$proposal->topic->name}}
                            @else
                                {{$proposal->adding_topic}}
                            @endif
                        </p>
                    </aside>

                    {{-- form --}}
                    <div class="mt-4 w-full p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <form class="space-y-4" wire:submit.prevent="assign">
                            <h5 class="text-base font-medium text-gray-900 dark:text-white">Assign an Advisor</h5>
                            <div class="@if($proposal->type !=  'journal') grid gap-4 md:grid-cols-2 @endif mb-2">
                                <div>
                                    <label for="lecturer_selected1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@if($proposal->type ==  'journal') Lecturer @else Lecturer(1) @endif</label>
                                    <select id="lecturer_selected1" name="lecturer_selected1" wire:model="lecturer_selected1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option hidden selected value="null" >Select lecturer 1</option>
                                        @foreach ($lecturers as $lecturer)
                                            <option value="{{$lecturer->id}}">{{$lecturer->user->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('lecturer_selected1') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div @if($proposal->type ==  'journal') class=hidden @endif>
                                    <label for="lecturer_selected2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lecturer(2)</label>
                                    <select id="lecturer_selected2" name="lecturer_selected2" wire:model="lecturer_selected2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option hidden selected value="null" >Select lecturer 2</option>
                                        @foreach ($lecturers as $lecturer)
                                            <option value="{{$lecturer->id}}">{{$lecturer->user->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('lecturer_selected2') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Assign</button>
                        </form>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
