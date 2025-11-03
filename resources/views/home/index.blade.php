@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    @if (!empty($heroSection))
        <section id="home" class="hero-gradient min-h-screen flex items-center relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center relative z-10">
                    <!-- Left Content -->
                    <div class="text-left order-2 lg:order-1">
                        <div
                            class="inline-flex items-center bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-3 py-2 mb-4 sm:mb-6 text-xs sm:text-sm">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-white/90 font-medium">{{ $heroSection?->tagLine }}</span>
                        </div>

                        <h1
                            class="text-3xl sm:text-4xl md:text-5xl xl:text-6xl font-black text-white mb-4 sm:mb-6 leading-tight text-shadow">
                            {{ $heroSection?->title }}
                            {{-- <span class="block bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                            {{ $heroSection->title }}
                        </span>
                        with Modern SaaS --}}
                        </h1>

                        <p class="text-base sm:text-lg md:text-xl text-blue-100/90 mb-6 sm:mb-8 leading-relaxed max-w-lg">
                            {{ $heroSection?->description }}
                        </p>

                        {{-- <div class="hidden lg:flex items-center space-x-3">
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
                    </div> --}}
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-6 sm:mb-8">
                            <button
                                onclick="window.location.href='{{ auth()->check() ? route('auth') : route('filament.admin.auth.register') }}'"
                                class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold text-base sm:text-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <i class="far fa-play-circle mr-2"></i>
                                {{ __('messages.landing.navigation.start_free_trial') }}
                            </button>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-6 text-blue-100/80">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                <span class="text-xs sm:text-sm">{{ __('messages.landing.hero.no_setup_fees') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                <span class="text-xs sm:text-sm">{{ __('messages.landing.hero.free_trial') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                <span class="text-xs sm:text-sm">{{ __('messages.landing.hero.cancel_anytime') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Floating Image -->
                    <div class="relative order-1 lg:order-2 mb-8 lg:mb-0">
                        <div class="floating-image">
                            <div class="relative">
                                <!-- Main Dashboard Image -->
                                <img src="{{ $heroSection?->image }}" alt="{{ __('messages.landing.hero.dashboard_alt') }}"
                                    class="w-full h-auto rounded-2xl shadow-2xl border border-white/10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/60 animate-bounce">
                <i class="fas fa-chevron-down text-xl"></i>
            </div>
        </section>
    @endif
    <!-- Features Section -->
    @if ($featureSection->isNotEmpty())
        <section id="features" class="py-24 bg-gradient-to-br from-slate-50 to-blue-50/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <div class="inline-flex items-center bg-indigo-100 text-indigo-800 rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-magic mr-2"></i>
                        <span class="text-sm font-semibold">{{ __('messages.landing.features.title') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                        {{ __('messages.landing.features.subtitle') }}</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ __('messages.landing.features.description') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featureSection as $feature)
                        <div
                            class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl relative overflow-hidden group">
                            <div
                                class="absolute inset-0 bg-gradient-to-br {{ $feature->hoverBg }} opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="relative z-10">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br {{ $feature->iconBg }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                                    <img src="{{ $feature->image }}" alt="{{ $feature->title }}"
                                        class="w-8 h-8 object-contain">
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $feature->title }}</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $feature->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
    <!-- Customer Dashboard Section -->
    @if (!empty($customerExperienceSection))
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="inline-flex items-center bg-purple-100 text-purple-800 rounded-full px-4 py-2 mb-6">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            <span
                                class="text-sm font-semibold">{{ __('messages.landing.customer_experience.title') }}</span>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                            {{ __('messages.landing.customer_experience.heading') }}</h2>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            {{ __('messages.landing.customer_experience.description') }}
                        </p>
                        @if (!empty($customerExperienceSection))
                            <div class="space-y-6">
                                @foreach ($customerExperienceSection->features as $item)
                                    <div class="flex items-start">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br {{ $item->iconBg }} rounded-lg flex items-center justify-center mr-4 mt-1 overflow-hidden">
                                            <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                                class="w-5 h-5 object-contain">
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->title }}</h4>
                                            <p class="text-gray-600">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div class="relative">
                        <div class="relative">
                            <img src="{{ $customerExperienceSection?->image }}"
                                alt="{{ __('messages.landing.customer_experience.dashboard_alt') }}"
                                class="rounded-2xl shadow-2xl border border-gray-200">

                            <!-- Floating notification -->
                            <div class="absolute -top-4 -right-4 bg-white rounded-xl p-4 shadow-lg border border-gray-100">
                                <div class="flex items-center mb-2">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                                    <span
                                        class="text-gray-900 text-sm font-semibold">{{ __('messages.landing.customer_experience.cards.payment_due') }}</span>
                                </div>
                                <p class="text-gray-600 text-xs">
                                    {{ __('messages.landing.customer_experience.cards.next_installment') }}</p>
                            </div>

                            <!-- Policy card -->
                            <div
                                class="absolute -bottom-6 -left-6 bg-white rounded-xl p-4 shadow-lg border border-gray-100">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-car text-blue-500 mr-2"></i>
                                    <span
                                        class="text-gray-900 text-sm font-semibold">{{ __('messages.landing.customer_experience.cards.auto_policy') }}</span>
                                </div>
                                <p class="text-gray-600 text-xs">
                                    {{ __('messages.landing.customer_experience.cards.coverage') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Why Choose Section -->
    @if ($whyChooseUsSection->isNotEmpty())
        <section class="py-24 bg-gradient-to-br from-indigo-50 to-purple-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <div
                        class="inline-flex items-center bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-star mr-2"></i>
                        <span class="text-sm font-semibold">{{ __('messages.landing.why_choose.title') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                        {{ __('messages.landing.why_choose.heading') }}</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ __('messages.landing.why_choose.description') }}
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-6 lg:gap-8">
                    @foreach ($whyChooseUsSection as $item)
                        <div class="text-center group w-full sm:w-auto sm:flex-1 sm:max-w-xs lg:max-w-sm">
                            <div
                                class="w-20 h-20 bg-gradient-to-br {{ $item->color }} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover rounded-2xl" />
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
    @if ($testimonialSection->isNotEmpty())
        <!-- Testimonials Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <div class="inline-flex items-center bg-emerald-100 text-emerald-800 rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-heart mr-2"></i>
                        <span class="text-sm font-semibold">{{ __('messages.landing.testimonials.title') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                        {{ __('messages.landing.testimonials.heading') }}</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ __('messages.landing.testimonials.description') }}
                    </p>
                </div>

                <!-- Testimonials Slider -->
                <div class="relative">
                    <div id="testimonial-slider" class="overflow-hidden rounded-2xl">
                        <div class="flex transition-transform duration-500 ease-in-out" id="testimonial-track">
                            @foreach ($testimonialSection as $testimonial)
                                <div class="w-full flex-shrink-0 px-2 md:px-4">
                                    <div
                                        class="bg-gradient-to-br {{ $testimonial->bgColor }} p-6 md:p-12 rounded-2xl border {{ $testimonial->borderColor }} shadow-xl">
                                        <div class="flex items-center mb-6 md:mb-8">
                                            @if ($testimonial->image)
                                                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}"
                                                    class="w-12 md:w-16 h-12 md:h-16 rounded-2xl mr-4 md:mr-6 object-cover" />
                                            @else
                                                 <img src="{{ asset('images/human.jpg') }}" alt="human"
                                                    class="w-12 md:w-16 h-12 md:h-16 rounded-2xl mr-4 md:mr-6 object-cover" />
                                            @endif
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-lg md:text-xl">
                                                    {{ $testimonial->name }}</h4>
                                                <p class="text-gray-600 text-sm md:text-lg">
                                                    {{ $testimonial->title }}</p>
                                            </div>
                                        </div>
                                        <blockquote
                                            class="text-gray-700 text-lg md:text-2xl leading-relaxed mb-6 md:mb-8 font-medium">
                                            "{{ $testimonial->description }}"
                                        </blockquote>
                                        <div class="flex text-yellow-500 text-lg md:text-xl">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Slider Controls (static or dynamic) -->
                    <div class="flex justify-center items-center mt-6 md:mt-8 space-x-3 md:space-x-4">
                        <button id="prev-testimonial"
                            class="w-10 md:w-12 h-10 md:h-12 bg-white hover:bg-gray-100 rounded-full shadow-lg flex items-center justify-center transition-all duration-300">
                            <i class="fas fa-chevron-left text-gray-600 text-sm md:text-base"></i>
                        </button>

                        <div class="flex space-x-1 md:space-x-2" id="testimonial-dots">
                            @foreach ($testimonialSection as $index => $testimonial)
                                <button
                                    class="w-2 md:w-3 h-2 md:h-3 rounded-full {{ $index === 0 ? 'bg-indigo-600' : 'bg-gray-300 hover:bg-gray-400' }} transition-all duration-300"
                                    data-slide="{{ $index }}"></button>
                            @endforeach
                        </div>

                        <button id="next-testimonial"
                            class="w-10 md:w-12 h-10 md:h-12 bg-white hover:bg-gray-100 rounded-full shadow-lg flex items-center justify-center transition-all duration-300">
                            <i class="fas fa-chevron-right text-gray-600 text-sm md:text-base"></i>
                        </button>
                    </div>
                </div>

            </div>
        </section>
    @endif
    <!-- Pricing Section -->
    @if ($subscriptionPlans->isNotEmpty())
        <section id="pricing" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <div class="inline-flex items-center bg-green-100 text-green-800 rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-tag mr-2"></i>
                        <span class="text-sm font-semibold">{{ __('messages.landing.pricing.title') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                        {{ __('messages.landing.pricing.heading') }}</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ __('messages.landing.pricing.description') }}
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-6 md:gap-8 lg:gap-12">
                    @foreach ($subscriptionPlans as $plan)
                        @php
                            $features = [
                                __('messages.landing.pricing.features.users', ['count' => $plan->user_limit]),
                                __('messages.landing.pricing.features.customers', [
                                    'count' => $plan->customer_limit,
                                ]),
                                __('messages.landing.pricing.features.agents', ['count' => $plan->agent_limit]),
                                $plan->is_show_history ? __('messages.payment_gateway.user_activity_history') : null,
                            ];
                            $features = array_filter($features);
                        @endphp

                        <div
                            class="w-full sm:w-80 md:flex-1 md:max-w-sm lg:max-w-md {{ $plan->is_popular ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white transform md:scale-105 hover:scale-105 md:hover:scale-110 shadow-2xl' : 'bg-white text-gray-900 border border-gray-200 shadow-lg hover:shadow-xl' }} rounded-3xl p-6 md:p-8 transition-all duration-300 relative">

                            @if ($plan->is_popular)
                                <div class="absolute -top-3 md:-top-4 left-1/2 transform -translate-x-1/2">
                                    <div
                                        class="bg-gradient-to-r from-orange-400 to-pink-500 text-white px-4 md:px-6 py-1 md:py-2 rounded-full text-xs md:text-sm font-bold shadow-lg">
                                        {{ __('messages.landing.pricing.most_popular') }}
                                    </div>
                                </div>
                            @endif

                            <div class="text-center">
                                <h3 class="text-xl md:text-2xl font-bold mb-2">{{ $plan->title }}</h3>
                                <p
                                    class="text-sm md:text-base {{ $plan->is_popular ? 'text-indigo-100' : 'text-gray-600' }} mb-4 md:mb-6">
                                    {{ $plan->short_description ?? __('messages.landing.pricing.default_description') }}
                                </p>
                                <div class="mb-4 md:mb-6">
                                    <span class="text-3xl md:text-5xl font-black">
                                        {{ $plan->amount === '0.00' ? __('messages.landing.pricing.free') : '$' . rtrim(rtrim($plan->amount, '0'), '.') }}
                                    </span>
                                    <span
                                        class="text-sm md:text-lg {{ $plan->is_popular ? 'text-indigo-100' : 'text-gray-600' }}">
                                        /&nbsp;{{ $plan->interval == 1 ? __('messages.landing.pricing.month') : __('messages.landing.pricing.year') }}
                                    </span>
                                </div>
                                @if (auth()->check() && auth()->user()->hasRole('admin'))
                                    <button
                                        onclick="window.location.href='{{ $plan->id == currentActivePlanId() ? route('auth') : route('to.payment', $plan) }}'"
                                        class="w-full {{ $plan->is_popular ? 'bg-white text-indigo-600 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800' }} py-3 md:py-4 px-4 md:px-6 rounded-xl font-bold text-sm md:text-base transition-all duration-300 shadow-lg">
                                        {{ $plan->id == currentActivePlanId() ? __('messages.subscription_plan.current_plan') : __('messages.subscription_plan.choose_payment_method') }}
                                    </button>
                                @else
                                    <button onclick="window.location.href='{{ route('filament.admin.auth.register') }}'"
                                        class="w-full {{ $plan->is_popular ? 'bg-white text-indigo-600 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800' }} py-3 md:py-4 px-4 md:px-6 rounded-xl font-bold text-sm md:text-base transition-all duration-300 shadow-lg">
                                        {{ __('messages.landing.pricing.start_trial') }}
                                    </button>
                                @endif
                            </div>

                            <div class="mt-6 md:mt-8 space-y-3 md:space-y-4">
                                @foreach ($features as $feature)
                                    <div class="flex items-center">
                                        <i
                                            class="fas fa-check {{ $plan->is_popular ? 'text-emerald-300' : 'text-green-500' }} mr-3"></i>
                                        <span
                                            class="text-sm md:text-base {{ $plan->is_popular ? 'text-white' : 'text-gray-700' }}">
                                            {{ $feature }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="text-center mt-12 md:mt-16">
                    <p class="text-sm md:text-base text-gray-600 mb-4">{{ __('messages.landing.pricing.trial_info') }}
                    </p>
                    <div
                        class="grid grid-cols-2 md:flex md:flex-wrap justify-center items-center gap-4 md:gap-8 text-xs md:text-sm text-gray-500">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-shield-check text-green-500 mr-2"></i>
                            <span>{{ __('messages.landing.pricing.compliance.soc2') }}</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-lock text-green-500 mr-2"></i>
                            <span>{{ __('messages.landing.pricing.compliance.security') }}</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-headset text-green-500 mr-2"></i>
                            <span>{{ __('messages.landing.pricing.compliance.support') }}</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-sync text-green-500 mr-2"></i>
                            <span>{{ __('messages.landing.pricing.compliance.uptime') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- FAQ Section -->
    @if ($faqSection->isNotEmpty())
        <section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50/30" id="faqs">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <div class="inline-flex items-center bg-blue-100 text-blue-800 rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-question-circle mr-2"></i>
                        <span class="text-sm font-semibold">{{ __('messages.landing.faq.title') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                        {{ __('messages.landing.faq.heading') }}</h2>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        {{ __('messages.landing.faq.description') }}
                    </p>
                </div>

                <div class="space-y-6">
                    @foreach ($faqSection as $index => $item)
                        @php $faqId = 'faq-' . $index; @endphp

                        <div
                            class="bg-white border border-gray-100 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left p-6 md:p-8 focus:outline-none"
                                data-target="{{ $faqId }}">
                                <h3 class="text-base md:text-xl font-bold text-gray-900 leading-snug max-w-[90%]">
                                    {{ $item->question }}
                                </h3>
                                <div
                                    class="w-8 h-8 shrink-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center ml-4">
                                    <i
                                        class="fas fa-chevron-down text-white text-xs transition-transform duration-300"></i>
                                </div>
                            </button>
                            <div id="{{ $faqId }}" class="faq-answer hidden px-6 md:px-8 pb-6 md:pb-8">
                                <p class="text-gray-600 text-base md:text-lg leading-relaxed">{{ $item->answer }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
    <!-- Contact/CTA Section -->
    <section id="contact" class="py-16 md:py-24 hero-gradient relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">

            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4 md:mb-6 text-shadow leading-tight">
                {{ __('messages.landing.cta.heading') }}</h2>
            <p class="text-base sm:text-lg md:text-xl text-blue-100/90 mb-8 md:mb-10 leading-relaxed max-w-2xl mx-auto">
                {{ __('messages.landing.cta.description') }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 md:gap-6 justify-center mb-6 md:mb-8">
                <a href="{{ auth()->check() ? route('auth') : route('filament.admin.auth.register') }}"
                    class="btn-primary text-white px-8 md:px-10 py-3 md:py-4 rounded-xl font-bold text-base md:text-lg shadow-2xl">
                    <i class="fas fa-rocket mr-2"></i>
                    {{ __('messages.landing.cta.button') }}
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-8 text-blue-100/80 text-sm md:text-base">
                <div class="flex items-center justify-center">
                    <i class="fas fa-credit-card text-emerald-400 mr-2"></i>
                    <span>{{ __('messages.landing.cta.features.no_credit_card') }}</span>
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-clock text-emerald-400 mr-2"></i>
                    <span>{{ __('messages.landing.cta.features.quick_setup') }}</span>
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-shield-check text-emerald-400 mr-2"></i>
                    <span>{{ __('messages.landing.cta.features.security') }}</span>
                </div>
            </div>
        </div>

        <!-- Background decoration -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-16 h-16 bg-white rounded-full animate-pulse"
                style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 right-1/4 w-12 h-12 bg-white rounded-full animate-pulse"
                style="animation-delay: 2s;"></div>
        </div>
    </section>
@endsection
