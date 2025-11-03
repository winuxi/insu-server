<div id="mobile-menu" class="mobile-menu lg:hidden fixed top-20 left-0 w-full shadow-2xl z-40 bg-white"
    style="height: calc(100vh - 5rem);">
    <div class="px-6 pt-6 pb-8 space-y-3">
        <a href="#home"
            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 block px-4 py-3 rounded-xl text-lg font-semibold transition-all duration-300">
            {{ __('messages.landing.navigation.home') }}
        </a>
        <a href="#features"
            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 block px-4 py-3 rounded-xl text-lg font-semibold transition-all duration-300">
            {{ __('messages.landing.navigation.features') }}
        </a>
        <a href="#pricing"
            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 block px-4 py-3 rounded-xl text-lg font-semibold transition-all duration-300">
            {{ __('messages.landing.navigation.pricing') }}
        </a>
        <a href="#contact"
            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 block px-4 py-3 rounded-xl text-lg font-semibold transition-all duration-300">
            {{ __('messages.landing.navigation.contact') }}
        </a>
        <div class="pt-4 space-y-3">
            <button onclick="window.location.href='{{ route('auth') }}'"
                class="text-gray-700 hover:text-sky-600 hover:bg-gray-100 block w-full px-4 py-3 rounded-xl text-lg font-semibold transition-all duration-300">
                {{ auth()->check() ? __('messages.navigation.dashboard') : __('messages.common.login') }}
            </button>
            @if (!auth()->check())
                <button onclick="window.location.href='{{ route('filament.admin.auth.register') }}'"
                    class="btn-primary text-white px-6 py-4 rounded-xl font-bold w-full text-lg shadow-lg">
                    <i class="fas fa-rocket mr-2"></i>
                    {{ __('messages.landing.navigation.start_free_trial') }}
                </button>
            @endif
        </div>
    </div>
</div>
