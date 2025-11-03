<div x-data="{ isLoading: false }">
    @if ($getRecord()->is_popular)
        <x-filament::badge color="info">
            {{ __('Most Popular') }}
        </x-filament::badge>
    @else
        <div type="button"
            x-on:click="
                if (!isLoading) {
                    isLoading = true;
                    $wire.call('changeIsPopular', {{ $getRecord()->id }}).then(() => {
                        isLoading = false;
                    }).catch(() => {
                        isLoading = false;
                    });
                }
            "
            :class="{ 'opacity-50 cursor-not-allowed': isLoading, 'cursor-pointer': !isLoading }"
            class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent outline-none transition-colors duration-200 ease-in-out bg-gray-200 dark:bg-gray-700 fi-color-gray"
            style="--c-600:var(--gray-600)"
            :disabled="isLoading">

            <span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-0">
            </span>
        </div>
    @endif
</div>
