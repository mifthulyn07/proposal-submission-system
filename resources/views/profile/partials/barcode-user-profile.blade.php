<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Your Barcode
        </h2>
    
        <p class="mt-1 text-sm text-gray-600">
            This barcode is used for the assignment note of proposal submission.
        </p>

        @if (session()->has('warning_barcode'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="mb-2 flex align-center justify-center alert-remove p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400" 
                role="alert"
            >
            <div class="flex items-center justify-center">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
            </div>
            <span class="font-bold mr-1">Warning alert!</span> {{ session('warning_barcode') }}
            </div>
        @endif
    </header>    

    @livewire('profile.barcode')
</section>

