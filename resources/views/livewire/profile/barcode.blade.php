<div>
    <form class="mt-6" wire:submit.prevent="update">
        
        {{-- barcode  --}}
        <div class="mb-4">
            <label for="barcode" class="hidden block text-sm font-medium text-gray-900 dark:text-white">Avatar</label>
            <div class="sm:flex sm:items-center">
                <div>
                    @if($barcode && !$errors->has('barcode'))
                        <img class="object-cover w-24 h-24 rounded-full mr-4" src="{{ $barcode->temporaryUrl() }}" alt="barcode"/>
                    @elseif($make_barcode_null == true)
                        <div class="flex justify-center items-center bg-gray-100 object-cover w-24 h-24 rounded-full mr-4" alt="avatar" width="32">
                            <svg class="w-6 h-6 text-gray-50 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/></svg>
                        </div>
                    @elseif($oldBarcode != null)
                        <img class="object-cover w-24 h-24 rounded-full mr-4" src="{{ asset('storage/barcodes/'.auth()->user()->lecturer->barcode) }}" alt="barcode"/>
                    @else
                        <div class="flex justify-center items-center bg-gray-100 object-cover w-24 h-24 rounded-full mr-4" alt="avatar" width="32">
                            <svg class="w-6 h-6 text-gray-50 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/></svg>
                        </div>   
                    @endif
                </div>
                <div>
                    <input type="file" id="barcode-upload-input" wire:model="barcode" id="{{ rand() }}" class="hidden">
                    <x-secondary-button class="mr-2 py-2 mt-2" id="barcode-upload-button">{{ __('Upload Barcode') }}</x-secondary-button>
                    @if($oldBarcode != null)
                        @if(!$barcode)   
                            <button wire:click.prevent="make_barcode_null()" id="remove-barcode-button" class="flex items-center py-3 text-sm font-medium text-red-600 rounded-b-lg dark:border-gray-600 dark:bg-red-700 dark:hover:text-red-600 dark:text-red-500 hover:underline">
                                <svg class="w-4 h-4 text-red-800 dark:text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/></svg>
                                Delete barcode
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            @error('barcode') <span class="error mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- button submit --}}
        <div class="flex items-center gap-4 mt-6" id="complete-profile">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
            @if (session()->has('success_barcode'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600"
                >{{ session('success_barcode') }}</p>
            @endif
            @if (session()->has('error_barcode'))
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
            $('#barcode-upload-button').click(function() {
                // Ketika tombol diklik, klik juga input file yang sebenarnya secara otomatis
                $('#barcode-upload-input').click();
            });
        });
    </script>
@endpush
