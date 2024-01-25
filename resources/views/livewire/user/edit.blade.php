<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            {{-- form --}}
            <div class="m-4 ">
                <h5 class="text-lg font-bold text-gray-900 dark:text-white">Update Account </h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This feature, can only be used by Coordinator and Kaprodi.</p>

                <form class="mt-6" wire:submit.prevent="update">
                    
                    {{-- avatar  --}}
                    <div class="mb-4">
                        <label for="avatar" class="block text-sm font-medium text-gray-900 dark:text-white">Avatar</label>
                        <div class="sm:flex sm:items-center">
                            <div>
                                @if ($avatar && !$errors->has('avatar'))
                                    <img class="object-cover w-24 h-24 rounded-full mr-4" src="{{ $avatar->temporaryUrl() }}" alt="avatar"/>
                                @elseif($make_avatar_null == true)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=e6f0ff&rounded=true" class="object-cover w-24 h-24 rounded-full mr-4" alt="avatar" width="32">
                                @endif    
                            </div>
                            <div class="lg:flex lg:items-center">
                                <input type="file" id="avatar-upload-input" wire:model="avatar" class="hidden">
                                <x-secondary-button class="mr-2 py-2 mt-2" id="avatar-upload-button">{{ __('Change Avatar') }}</x-secondary-button>
                                @if(!$avatar_null)
                                    @if(!$avatar)
                                        <button wire:click.prevent="make_avatar_null()" class="flex items-center py-3 text-sm font-medium text-red-600 rounded-b-lg dark:border-gray-600 dark:bg-red-700 dark:hover:text-red-600 dark:text-red-500 hover:underline">
                                            <svg class="w-4 h-4 text-red-800 dark:text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/></svg>
                                            Delete avatar
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @error('avatar') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- name & email --}}
                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input autocomplete="off" type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe">
                            @error('name') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input autocomplete="off" type="text" wire:model="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="johndoe@example.com">
                            @error('email') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- gender & phone --}}
                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                        <div>
                            <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                            <select id="gender" name="gender" wire:model="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option hidden>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('gender') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                            <input type="text" id="phone" wire:model="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0812345678">
                            @error('phone') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- password & password confirmation --}}
                    <div class="grid gap-4 mb-4 md:grid-cols-2">
                        <div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input @if($show_password == 'show') type="text" @else type="password" @endif id="password" wire:model="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="*****">
                            </div>
                            <div>
                                <input id="show_password" type="checkbox" value="show" wire:model="show_password" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                                <label for="show_password" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Show Password</label>
                            </div>
                            @error('password') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="*****">
                            @error('password_confirmation') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- roles --}}
                    <div class="mb-4">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select id="role" name="role" wire:model="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected hidden value="" >Select Role</option>
                            @foreach ($roles as $role)
                                @if($userWithRoleKaprodiExists)
                                    @if($role->name === 'kaprodi')
                                        @continue
                                    @endif
                                @endif
                                <option value="{{$role->id}}">{{ ucwords($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- button submit --}}
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
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