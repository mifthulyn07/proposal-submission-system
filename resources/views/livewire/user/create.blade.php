<div>

    {{-- popup if user offline  --}}
    @include('components.offline')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            {{-- form --}}
            <div class="m-4">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Add a new account</h5>
                <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">This feature, can only be used by Coordinator.</p>

                <form class="mt-6" wire:submit.prevent="store">
                   
                    {{-- avatar  --}}
                    <div class="mb-4">
                        <label for="avatar" class="block text-sm font-medium text-gray-900 dark:text-white">Avatar</label>
                        <div class="sm:flex sm:items-center">
                            @if ($avatar && !$errors->has('avatar'))
                                <img class="object-cover w-24 h-24 rounded-full mr-4" src="{{ $avatar->temporaryUrl() }}" alt="avatar"/>
                            @endif
                            <input type="file" id="avatar-upload-input" wire:model="avatar" class="hidden">
                            <x-secondary-button class="py-2 mt-2" id="avatar-upload-button">{{ __('Change Avatar') }}</x-secondary-button>
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
                            <input type="text" id="phone" wire:model="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="08123456789">
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
                        <h3 class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Roles</h3>
                        <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach ($roles as $role)
                                <li class="w-full border-b border-gray-200 md:border-b-0 md:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input type="checkbox"  wire:model="selected_roles" value="{{ $role->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="vue-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ ucwords($role->name) }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @error('selected_roles') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
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
            $('#avatar-upload-button').click(function() {
                // Ketika tombol diklik, klik juga input file yang sebenarnya secara otomatis
                $('#avatar-upload-input').click();
            });
        });
    </script>
@endpush