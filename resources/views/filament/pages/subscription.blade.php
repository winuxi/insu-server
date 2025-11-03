<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ __('messages.subscription.choose_your_plan') }}
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                {{ __('messages.subscription.select_perfect_plan') }}
            </p>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex justify-center">
            <x-filament::tabs>
                <x-filament::tabs.item
                    :active="$activeTab === 'monthly'"
                    wire:click="switchTab('monthly')"
                >
                    {{ __('messages.subscription.monthly') }}
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    :active="$activeTab === 'yearly'"
                    wire:click="switchTab('yearly')"
                >
                    <div class="flex items-center gap-2">
                        {{ __('messages.subscription.yearly') }}
                    </div>
                </x-filament::tabs.item>
            </x-filament::tabs>
        </div>

        {{-- Subscription Plans Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            @php
                $plans = $this->getSubscriptionPlans()[$activeTab];
            @endphp

            @if(count($plans) > 0)
                @foreach($plans as $planKey => $plan)
                    <x-filament::section
                        :class="'relative'"
                    >
                        {{-- Popular Badge --}}

                        <div class="text-center space-y-4 pt-2">
                            {{-- Plan Name --}}
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $plan['name'] }}
                            </h3>

                            {{-- Price --}}
                            <div class="space-y-2">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $plan['price'] }}
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        / {{ $activeTab === 'monthly' ? __('messages.subscription.month') : __('messages.subscription.year') }}
                                    </span>
                                </div>

                                @if($activeTab === 'yearly' && isset($plan['original_price']))
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="line-through">{{ $plan['original_price'] }}</span>
                                        <span class="ml-2 text-green-600 dark:text-green-400 font-medium">
                                            {{ __('messages.plans.save_price', ['price' => $plan['savings']]) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Description --}}
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $plan['description'] }}
                            </p>

                            {{-- Features List --}}
                            <div class="space-y-3">
                                @foreach($plan['features'] as $feature)
                                    <div class="flex items-center gap-2">
                                        <x-filament::icon
                                            icon="heroicon-o-check"
                                            class="w-4 h-4 text-green-600 dark:text-green-400 flex-shrink-0"
                                        />
                                        <span class="text-sm text-gray-450 text-left">
                                            {{ $feature }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Purchase Button --}}
                            <div class="pt-4">
                                {{ ($this->purchaseAction)(['plan_id' => $plan['id']]) }}
                            </div>
                        </div>
                    </x-filament::section>
                @endforeach
            @else
                <div class="col-span-full text-center py-12">
                    <x-filament::icon
                        icon="heroicon-o-exclamation-triangle"
                        class="w-8 h-8 text-gray-400 mx-auto mb-4"
                    />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        {{ __('messages.plans.no_plans_available_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.plans.no_plans_available_body', ['tab' => $activeTab]) }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Contact Support --}}
        <div class="text-center pt-8">
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('messages.subscription.need_help') }}
                <x-filament::link href="mailto:support@example.com" class="ml-1">
                    {{ __('messages.subscription.contact_sales') }}
                </x-filament::link>
            </p>
        </div>
    </div>
</x-filament-panels::page>
