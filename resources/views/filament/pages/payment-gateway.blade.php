<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header with Back Button --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ __('messages.payment_gateway.payment_methods') }}
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('messages.payment_gateway.select_preferred_method') }}
                </p>
            </div>
            <div>
                {{ $this->backToPlanAction }}
            </div>
        </div>

        {{-- Selected Plan Summary --}}
        @if ($selectedPlan)
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-check-circle"
                            class="w-5 h-5 text-green-600 dark:text-green-400" />
                        {{ __('messages.subscription_plan.selected_plan') }}
                    </div>
                </x-slot>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $selectedPlan['name'] ?? ($selectedPlan['title'] ?? __('messages.subscription_plan.unknown_plan')) }} {{ __('messages.plans.plan') }}
                        </h3>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ currencySymbol() . $selectedPlan['amount'] ?? '$0.00' }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">
                                /
                                {{ $selectedPlan['billing_cycle'] ?? (App\Models\Plan::INTERVALS[$selectedPlan['interval']] ?? __('messages.plans.month')) }}
                            </span>
                        </div>
                    </div>

                    {{-- Plan Features --}}
                    @if (!empty($selectedPlan['features']))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
                            @foreach ($selectedPlan['features'] as $feature)
                                <div class="flex items-center gap-2">
                                    <x-filament::icon icon="heroicon-o-check"
                                        class="w-4 h-4 text-green-600 dark:text-green-400 flex-shrink-0" />
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ is_array($feature) ? $feature['name'] ?? ($feature['title'] ?? __('messages.plans.feature')) : $feature }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Plan Limits Summary --}}
                    @php
                        $limits = $this->getPlanLimitsDisplay();
                    @endphp
                    @if (!empty($limits))
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                {{ __('messages.plans.plan_limits') }}:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                @foreach ($limits as $limit)
                                    <div class="flex items-center gap-2">
                                        <x-filament::icon icon="heroicon-o-information-circle"
                                            class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                        <span class="text-sm text-gray-450">
                                            {{ $limit }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </x-filament::section>
        @else
            {{-- Show message if no plan is selected --}}
            <x-filament::section>
                <div class="text-center py-8">
                    <x-filament::icon icon="heroicon-o-exclamation-triangle"
                        class="w-12 h-12 text-yellow-500 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        {{ __('messages.payment_gateway.no_plan_selected_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.payment_gateway.no_plan_selected_body') }}
                    </p>
                </div>
            </x-filament::section>
        @endif

        {{-- Payment Methods Grid --}}
        <x-filament::section>
            <x-slot name="heading">
                {{ __('messages.payment_gateway.available_payment_methods') }}
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if (empty($this->getPaymentGateways()))
                    <div>
                        <p>{{ __('messages.payment_gateway.no_gateways_available') }}</p>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.payment_gateway.try_later') }}</span>
                    </div>
                @endif
                @foreach ($this->getPaymentGateways() as $gatewayKey => $gateway)
                    <div wire:click="selectGateway('{{ $gatewayKey }}')"
                        class="relative cursor-pointer rounded-lg border-2 p-4 transition-all duration-200 hover:shadow-md
                            {{ $selectedGateway === $gatewayKey
                                ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20'
                                : 'border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500' }}">
                        {{-- Popular Badge --}}

                        {{-- Radio Button --}}
                        {{-- <div class="absolute top-4 right-4">
                            <div class="flex items-center">
                                <input type="radio" name="payment_gateway" value="{{ $gatewayKey }}"
                                    {{ $selectedGateway === $gatewayKey ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    readonly>
                            </div>
                        </div> --}}

                        {{-- Gateway Header --}}
                        <div class="space-y-3">
                            <div class="flex items-center gap-3" {{-- style="margin-top: 25px" --}}>
                                <x-filament::icon :icon="$gateway['icon']"
                                    class="pl-4 w-6 h-6 text-gray-600 dark:text-gray-400" />
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $gateway['name'] }}
                                </h3>
                            </div>

                            {{-- Description --}}
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ $gateway['description'] }}
                            </p>

                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Security Notice --}}
        <x-filament::section>
            <div class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <x-filament::icon icon="heroicon-o-shield-check"
                    class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                <div class="space-y-1">
                    <h4 class="font-medium text-blue-900 dark:text-blue-100">
                        {{ __('messages.payment_gateway.secure_payment_processing') }}
                    </h4>
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        {{ __('messages.payment_gateway.secure_payment_notice_1') }}
                        {{ __('messages.payment_gateway.secure_payment_notice_2') }}
                    </p>
                </div>
            </div>
        </x-filament::section>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                @if ($selectedGateway)
                    {{ __('messages.payment_gateway.selected') }}: <span
                        class="font-medium">{{ $this->getPaymentGateways()[$selectedGateway]['name'] }}</span>
                @else
                    {{ __('messages.payment_gateway.please_select_payment_method') }}
                @endif
            </div>

            <div class="flex items-center gap-3">
                {{ $this->backToPlanAction }}
                {{ $this->processPaymentAction }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
