<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">

            @if(!$empty)
                {{-- form --}}
                <div class="m-4 ">
                    <h5 class="text-xl font-medium text-gray-900 dark:text-white">Edit Proposal's Title</h5>
                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This proposal's title is for an information systems student from the State Islamic University of North Sumatra.</p>

                    <form class="mt-6" wire:submit.prevent="update">
                        <div class="mb-6">
                            <label for="student_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student Account</label>
                            <select id="student_id" name="student_id" wire:model="student_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="" >Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{$student->id}}">{{$student->user->name}} ({{$student->user->email}})</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student's Name</label>
                                <input type="text" wire:model="name" id="name" @if(!empty($this->student_id)) disabled aria-label="disabled input" @endif class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" >
                                @error('name') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                <input type="text" wire:model="nim" id="nim" @if(!empty($this->student_id)) disabled @endif class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0712345678">
                                @error('nim') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="topic_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Topic Proposal</label>
                                <select id="topic_id" name="topic_id" wire:model="topic_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="" >Select topic</option>
                                    @foreach ($topics as $topic)
                                        <option value="{{$topic->id}}">{{$topic->name}}</option>
                                    @endforeach
                                </select>
                                @error('topic_id') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type Proposal</label>
                                <select id="type" name="type" wire:model="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="" >Select Type</option>
                                    <option selected value="skripsi" >Skripsi</option>
                                    <option selected value="teknologi_tepat_guna" >Teknologi Tepat Guna</option>
                                    <option selected value="jurnal" >Jurnal</option>
                                </select>
                                @error('type') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
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
                        <div class="mb-6">
                            <label for="Proposal's Title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proposal's Title</label>
                            <input type="text" id="title" wire:model="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Implementation of Machine Learning for Attendance Tracking Application">
                            @error('title') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center gap-4">
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
            @else
                <div class="m-4">
                    <div class="flex flex-col justify-center items-center px-6 mx-auto h-screen xl:px-0 dark:bg-gray-900">
                        <div class="block max-w-lg">
                            <img src="/assets/illustrations/404.svg" alt="astronaut image">
                        </div>
                        <div class="text-center xl:max-w-4xl">
                            <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">Not found</h1>
                            <p class="mb-5 text-base font-normal text-gray-500 md:text-lg dark:text-gray-400">Oops! Looks like you followed a bad link. If you think this is a problem with us, please tell us.</p>
                            <a href="{{ Route('proposal.read') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Go back
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

