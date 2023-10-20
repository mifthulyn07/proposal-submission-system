<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            {{-- form --}}
            <div class="m-4 ">
                <h5 class="text-lg font-medium text-gray-900 dark:text-white">Edit Proposal</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Make sure you've read and understood all the requirements before proceeding.</p>

                <form class="mt-6" wire:submit.prevent="update">
                    
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

                    {{-- title --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title of proposal</label>
                        <input type="text" wire:model="title" @if($similarity) disabled aria-label="disabled input" @endif id="title" class="@if($similarity) bg-gray-100 cursor-not-allowed @else bg-gray-50 @endif  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Implementation of Machine Learning for Attendance Tracking Application">
                        @error('title') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- similarity --}}
                    <div class="mb-4">
                        <label for="similarity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Similarity</label>
                        <div class="flex">
                            <input disabled type="text" aria-label="disabled input" wire:model="similarity" id="similarity" class="bg-gray-100 cursor-not-allowed rounded-none rounded-l-lg border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Go check similarity first!">
                            <span class="inline-flex items-center px-3 text-sm text-gray-600 bg-gray-200 border border-r-0 border-gray-300 font-bold rounded-r-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">%</span>
                        </div>
                        @error('similarity') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">To check the similarity of your title, click <a href="{{ route('similarity.check', $title) }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">here</a>. You can view the percentage of similarity with this tool.</p>                          
                    </div>

                    {{-- proposal --}}
                    <div class="mb-4">
                        <div>
                            <label for="proposal" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Proposal: pdf</label>
                            <input type="file" id="file-upload-input" wire:model="proposal" class="hidden">
                            <x-secondary-button class="mr-2 py-2 mt-1" id="file-upload-button">{{ __('Search File') }}</x-secondary-button>
                            @if($proposal) 
                                <span class="mt-2 text-sm text-gray-800 dark:text-gray-800"> {{ $proposal->getClientOriginalName() }} </span> 
                            @endif
                        </div>
                        @error('proposal') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">To submit your proposal, please use the provided template and follow the submission procedures.</p>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#file-upload-button').click(function() {
                // Ketika tombol diklik, klik juga input file yang sebenarnya secara otomatis
                $('#file-upload-input').click();
            });
        });
    </script>
@endpush