<!-- Sticky Navigation -->
<nav class="bg-white/95 backdrop-blur-xl shadow-lg sticky top-0 z-50 border-b border-gray-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <div class="w-20 h-20 bg-gradient-to-br rounded-2xl flex items-center justify-center mr-4 p-2">
                    <img src="{{ appLandingLogo() }}" alt="logo">
                </div>

            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:block">
                <div class="flex items-center space-x-1" x-data="{ active: 'home' }">
                    @if (!empty($heroSection))
                        <a href="#home" x-on:click="active = 'home'"
                            :class="{ 'text-sky-600 bg-sky-50': active === 'home' }"
                            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
                            {{ __('messages.landing.navigation.home') }}
                        </a>
                    @endif
                    @if ($featureSection->isNotEmpty())
                        <a href="#features" x-on:click="active = 'features'"
                            :class="{ 'text-sky-600 bg-sky-50': active === 'features' }"
                            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
                            {{ __('messages.landing.navigation.features') }}
                        </a>
                    @endif
                    @if ($subscriptionPlans->isNotEmpty())
                        <a href="#pricing" x-on:click="active = 'pricing'"
                            :class="{ 'text-sky-600 bg-sky-50': active === 'pricing' }"
                            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
                            {{ __('messages.landing.navigation.pricing') }}
                        </a>
                    @endif
                    <a href="#contact" x-on:click="active = 'contact'"
                        :class="{ 'text-sky-600 bg-sky-50': active === 'contact' }"
                        class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
                        {{ __('messages.landing.navigation.contact') }}
                    </a>
                    @if ($faqSection->isNotEmpty())
                        <a href="#faqs" x-on:click="active = 'faqs'"
                            :class="{ 'text-sky-600 bg-sky-50': active === 'faqs' }"
                            class="text-gray-700 hover:text-sky-600 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
                            {{ __('FAQs') }}
                        </a>
                    @endif
                    <!-- Language Dropdown -->
                    @livewire('language-switcher')
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="hidden lg:flex items-center space-x-3">
                <a href="{{ route('auth') }}"
                    class="text-gray-700 hover:text-sky-600 px-4 py-2 rounded-xl font-semibold transition-all duration-300">
                    {{ auth()->check() ? __('messages.navigation.dashboard') : __('messages.common.login') }}
                </a>
                @if (!auth()->check())
                    <button onclick="window.location.href='{{ route('filament.admin.auth.register') }}'"
                        class="btn-primary text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>
                        {{ __('messages.landing.navigation.start_free_trial') }}
                    </button>
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button id="mobile-menu-button"
                    class="text-gray-700 hover:text-sky-600 focus:outline-none p-2 rounded-xl hover:bg-gray-100 transition-all duration-300">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    @include('layouts.mobile-navigation')
</nav>
