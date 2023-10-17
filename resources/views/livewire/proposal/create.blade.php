<div>
    {{-- popup if user offline  --}}
    @include('components.offline')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            {{-- form --}}
            <div class="m-4 ">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Add a new proposal's title</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This proposal's title is for an information systems student from the State Islamic University of North Sumatra.</p>

                <form class="mt-6" wire:submit.prevent="store">
                    
                    {{-- student id --}}
                    <div class="mb-4">
                        <label for="student_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student Account</label>
                        <select id="student_id" name="student_id" wire:model="student_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected hidden value="" >Select Student</option>
                            <option value="" >Student dont have an account</option>
                            @foreach ($students as $student)
                                <option value="{{$student->id}}">{{$student->user->name}} ({{$student->user->email}})</option>
                            @endforeach
                        </select>
                        @error('student_id') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    {{-- name & nim--}}
                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student's Name</label>
                            <input type="text" wire:model="name" id="name" @if(!empty($this->student_id)) disabled aria-label="disabled input" @endif class="@if(!empty($this->student_id)) bg-gray-100 @else bg-gray-50 @endif border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" >
                            @error('name') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                            <input type="text" wire:model="nim" id="nim" @if(!empty($this->student_id)) disabled @endif class="@if(!empty($this->student_id)) bg-gray-100 @else bg-gray-50 @endif border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0712345678">
                            @error('nim') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- type --}}
                    <div class="mb-4">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type Proposal</label>
                        <select id="type" name="type" wire:model="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option hidden selected value="" >Select Type</option>
                            <option value="thesis" >Thesis</option>
                            <option value="appropriate_technology" >Appropriate Technology</option>
                            <option value="journal" >Journal</option>
                        </select>
                        @error('type') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- topic --}}
                    <div class="@if($another_topic) grid gap-4 md:grid-cols-2 @endif mb-4">
                        <div>
                            <label for="topic_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Topic of proposal</label>
                            <select @if($another_topic) disabled @endif id="topic_id" name="topic_id" wire:model="topic_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option hidden>Choose Topic</option>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                            @error('topic_id') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                            <div>
                                <input id="another_topic" type="checkbox" value="show" wire:model="another_topic" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                                <label for="another_topic" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Another topic?</label>
                            </div>
                        </div>
                        <div @if (!$another_topic) class="hidden" @endif>
                            <label for="adding_topic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adding Topic</label>
                            <input autocomplete="off" type="text" wire:model="adding_topic" id="adding_topic" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill here">
                            @error('adding_topic') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- year & status --}}
                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                        <div>
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year of Proposal</label>
                            <input type="text" id="year" wire:model="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="2023">
                            @error('year') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Proposal</label>
                            <select id="status" name="status" wire:model="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="" >Select Status</option>
                                <option selected value="done" >Done</option>
                                <option selected value="on_process" >On Process</option>
                            </select>
                            @error('status') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- title --}}
                    <div class="mb-4">
                        <label for="Proposal's Title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proposal's Title</label>
                        <input type="text" id="title" wire:model="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Implementation of Machine Learning for Attendance Tracking Application">
                        @error('title') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- button submit --}}
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        @if (session()->has('success'))
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-green-600"
                            >{{ session('success') }}</p>
                        @endif
                        @if (session()->has('error'))
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-red-600"
                            >{{ session('error') }}</p>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
