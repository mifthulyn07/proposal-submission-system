<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">

            {{-- form --}}
            <div class="m-4 ">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Add Topic of Proposal</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This topic will be part of the proposal category</p>

                <form class="mt-6" wire:submit.prevent="store">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name of Topic</label>
                        <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Machine learning">
                        @error('name') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-6">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Date</label>
                        <input type="date" wire:model="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
        </div>
    </div>
</div>