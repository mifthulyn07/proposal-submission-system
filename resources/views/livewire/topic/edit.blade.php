<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">

            @if(!$empty)
                {{-- form --}}
                <div class="m-4 ">
                    <h5 class="text-xl font-medium text-gray-900 dark:text-white">Edit topic of proposal</h5>
                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This topic will be part of the proposal category.</p>

                    <form class="mt-6" wire:submit.prevent="update">
                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name of Topic</label>
                            <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe">
                            @error('name') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-6">
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">current Date</label>
                            <input type="date" id="date" wire:model="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Implementation of Machine Learning for Attendance Tracking Application">
                            @error('date') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
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
                            <a href="{{ Route('topic.read') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
