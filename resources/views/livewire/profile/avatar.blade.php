<div>
    <form class="mt-6" wire:submit.prevent="update">
        
        {{-- avatar  --}}
        <div class="mb-4">
            <label for="avatar" class="hidden block text-sm font-medium text-gray-900 dark:text-white">Avatar</label>
            <div class="sm:flex sm:items-center">
                <div>
                    @if($avatar && !$errors->has('avatar'))
                        <img class="object-cover w-24 h-24 rounded-full mr-4" src="{{ $avatar->temporaryUrl() }}" alt="avatar"/>
                    @elseif ($avatar_null) 
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e6f0ff&rounded=true" class="object-cover w-24 h-24 rounded-full mr-4" alt="avatar" width="32">
                    @elseif($make_avatar_null)
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e6f0ff&rounded=true" class="object-cover w-24 h-24 rounded-full mr-4" alt="avatar" width="32">
                    @elseif($avatar_null == false)
                        <img class="object-cover w-24 h-24 rounded-full mr-4" src="{{ asset('storage/avatars/'.auth()->user()->avatar) }}" alt="avatar"/>
                    @endif
                </div>
                <div>
                    <input type="file" id="avatar-upload-input" wire:model="avatar" id="{{ rand() }}" class="hidden">
                    <x-secondary-button class="mr-2 py-2 mt-2" id="avatar-upload-button">{{ __('Change Avatar') }}</x-secondary-button>
                    @if(!$avatar_null)
                        @if(!$avatar)   
                            <button wire:click.prevent="make_avatar_null()" id="remove-avatar-button" class="flex items-center py-3 text-sm font-medium text-red-600 rounded-b-lg dark:border-gray-600 dark:bg-red-700 dark:hover:text-red-600 dark:text-red-500 hover:underline">
                                <svg class="w-4 h-4 text-red-800 dark:text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/></svg>
                                Delete avatar
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            @error('avatar') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- button submit --}}
        <div class="flex items-center gap-4 mt-6" id="complete-profile">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#avatar-upload-button').click(function() {
                // Ketika tombol diklik, klik juga input file yang sebenarnya secara otomatis
                $('#avatar-upload-input').click();
            });
        });
    </script>
@endpush
