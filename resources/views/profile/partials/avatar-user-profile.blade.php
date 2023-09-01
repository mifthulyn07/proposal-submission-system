<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Personalize your account with a photo, so that you will be easily recognized") }}
        </p>
    </header>

    @livewire('profile.avatar')
</section>

@push('scripts')
    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[id="image"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            server: {
            url:  '/upload',
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            }
        });
    </script>
@endpush

