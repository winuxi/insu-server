<div class="relative ml-2" x-data="{ open: false }">
    <button @click="open = !open"
        class="flex items-center text-gray-700 hover:text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
        <span class="mr-2 text-2xl">{{ $this->languageLabel['flag'] }}</span>
        <span class="mr-1">{{ __($this->languageLabel['label']) }}</span>
        <i class="fas fa-chevron-down ml-1 text-xs"></i>
    </button>

    <div x-show="open" @click.outside="open = false"
        class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
        @foreach ($languages as $code => $data)
            <button wire:click="switchLanguage('{{ $code }}')"
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600 transition-colors {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}">
                <span class="mr-2 text-2xl">{{ $data['flag'] }}</span>
                <span>{{ __($data['label']) }}</span>
            </button>
        @endforeach
    </div>
</div>
