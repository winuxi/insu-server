<?php

namespace App\Filament\Pages;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth; // Added Auth Facade
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class paymentGateway extends Page implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    // protected static ?string $navigationLabel = 'Payment Methods'; // Now handled by getNavigationLabel()
    // protected static ?string $title = ''; // Title for this page is likely dynamic or not set statically

    protected static string $view = 'filament.pages.payment-gateway';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $selectedPlan = null;

    public ?string $selectedGateway = null;

    public function mount(): void
    {
        $this->selectedPlan = session('selected_plan');

        // Redirect back if no plan is selected
        if (! $this->selectedPlan) {
            Notification::make()
                ->title(__('messages.payment_gateway.no_plan_selected_title'))
                ->body(__('messages.payment_gateway.no_plan_selected_body'))
                ->warning()
                ->send();

            redirect()->route('filament.admin.pages.subscription');
        }
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.payment_gateway.payment_methods');
    }

    // public function getTitle(): string // Title is usually dynamic based on selected plan or context
    // {
    //     return __('messages.payment_gateway.payment_methods');
    // }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::FiveExtraLarge;
    }

    public function selectGateway(string $gateway): void
    {
        $this->selectedGateway = $gateway;
    }

    public function backToPlanAction(): Action
    {
        return Action::make('backToPlan')
            ->label(__('messages.payment_gateway.back_to_plans'))
            ->color('gray')
            ->outlined()
            ->action(function () {
                session()->forget('selected_plan');

                return redirect()->route('filament.admin.pages.subscription');
            });
    }

    public function processPaymentAction(): Action
    {
        return Action::make('processPayment')
            ->label(__('messages.payment_gateway.continue_to_payment'))
            ->color('primary')
            // ->size('lg')
            ->disabled(fn () => ! $this->selectedGateway)
            ->requiresConfirmation()
            ->modalHeading(__('messages.payment_gateway.confirm_payment_method'))
            ->modalDescription(function () {
                if (! $this->selectedGateway || ! $this->selectedPlan) {
                    return __('messages.payment_gateway.please_select_payment_method');
                }

                $gatewayName = $this->getPaymentGateways()[$this->selectedGateway]['name'] ?? 'Unknown'; // Gateway name is already localized in getPaymentGateways
                $planName = $this->selectedPlan['name'] ?? $this->selectedPlan['title'] ?? 'Unknown Plan';
                $planPrice = currencySymbol().$this->selectedPlan['amount'] ?? '$0.00';
                $billingCycle = $this->selectedPlan['billing_cycle'] ?? 'month'; // 'month' could be localized if needed

                return __('messages.payment_gateway.redirect_confirmation', [
                    'gatewayName' => $gatewayName,
                    'planName' => $planName,
                    'planPrice' => $planPrice,
                    'billingCycle' => $billingCycle,
                ]);
            })
            ->action(function () {
                $this->processPayment();
            });
    }

    protected function processPayment(): void
    {
        if (! $this->selectedGateway || ! $this->selectedPlan) {
            Notification::make()
                ->title(__('messages.payment_gateway.invalid_selection_title'))
                ->body(__('messages.payment_gateway.invalid_selection_body'))
                ->danger()
                ->send();

            return;
        }

        // Validate that the plan still exists in database
        $plan = Plan::find($this->selectedPlan['id']);
        if (! $plan) {
            Notification::make()
                ->title(__('messages.payment_gateway.plan_not_available_title'))
                ->body(__('messages.payment_gateway.plan_not_available_body'))
                ->danger()
                ->send();
            redirect()->route('filament.admin.pages.subscription');
        }

        // Store payment gateway selection in session
        session([
            'selected_gateway' => $this->selectedGateway,
            'payment_session' => [
                'plan' => $this->selectedPlan,
                'gateway' => $this->selectedGateway,
                'timestamp' => now(),
            ],
        ]);

        // Redirect based on gateway
        switch ($this->selectedGateway) {
            case 'stripe':
                $this->redirectToStripe();
                break;
            case 'paypal':
                $this->redirectToPayPal();
                break;
            case 'manual':
                $this->redirectToManual();
                break;
            default:
                Notification::make()
                    ->title(__('messages.payment_gateway.gateway_not_available_title'))
                    ->body(__('messages.payment_gateway.gateway_not_available_body'))
                    ->warning()
                    ->send();
        }
    }

    protected function redirectToStripe()
    {
        if (! empty(stripeCredentials()) && ! empty($this->selectedPlan)) {
            $stripeKey = stripeCredentials()['secret'];
            Stripe::setApiKey($stripeKey);

            try {
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'product_data' => [
                                    'name' => 'Payment for ', // This could be localized if needed, e.g., __('messages.payment_gateway.payment_for_plan', ['planName' => $this->selectedPlan['name'] ?? 'Unknown Plan'])
                                ],
                                'unit_amount' => $this->selectedPlan['amount'] * 100,
                                'currency' => Str::lower(currencyCode()),
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'client_reference_id' => uniqid(),
                    'mode' => 'payment',
                    'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('stripe.failed'),
                    'metadata' => [
                        'user_id' => Auth::id(), // Corrected: Was auth()->id()
                        'plan_id' => $this->selectedPlan['id'],
                    ],
                ]);

                return redirect($session->url);
            } catch (Exception $e) {
                notify($e->getMessage(), 'danger'); // Error messages from external services are harder to localize directly

                $this->halt();
            }
        }
    }

    protected function redirectToPayPal()
    {
        if (! empty(paypalCredentials()) && ! empty($this->selectedPlan)) {
            try {
                $amount = $this->selectedPlan['amount'];
                $purchaseNo = uniqid();
                $mode = paypalCredentials()['mode'];
                $clientId = paypalCredentials()['client'];
                $clientSecret = paypalCredentials()['secret'];
                $config = [
                    'mode' => $mode,
                    'sandbox' => [
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'app_id' => 'APP-80W284485P519543T',
                    ],
                    'live' => [
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'app_id' => 'APP-80W284485P519543T',
                    ],
                    'payment_action' => 'Sale',
                    'currency' => currencyCode(),
                    'notify_url' => '',
                    'locale' => 'en_US', // PayPal locale can be set here
                    'validate_ssl' => true,
                ];

                $provider = new PayPalClient($config);
                $provider->getAccessToken();

                $data = [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'reference_id' => $purchaseNo,
                            'amount' => [
                                'value' => $amount,
                                'currency_code' => currencyCode(),
                            ],
                        ],
                    ],
                    'application_context' => [
                        'cancel_url' => route('paypal.failed'),
                        'return_url' => route('paypal.success'),
                    ],
                ];

                $order = $provider->createOrder($data);

                if (array_key_exists('error', $order)) {
                    $data['error'] = $order['error'];

                    throw new Exception($data['error']['message']);
                }

                $url = $order['links'][1]['href'];
                session(['paypal_input' => $this->selectedPlan]);

                return redirect()->away($url);
            } catch (Exception $e) {
                notify($e->getMessage(), 'danger');

                $this->halt();
            }
        }
    }

    protected function redirectToManual()
    {
        Subscription::create([
            'user_id' => Auth::id(), // Corrected: Was auth()->id()
            'plan_id' => $this->selectedPlan['id'],
            'amount' => $this->selectedPlan['amount'],
            'payment_method' => 'manual',
            'payment_status' => Subscription::IN_REVIEW,
            'is_active' => Subscription::INACTIVE,
            'tenant_id' => Auth::user()->tenant_id, // Corrected: Was auth()->user()->tenant_id
        ]);

        Notification::make()
            ->title(__('messages.payment_gateway.payment_pending_title'))
            ->body(__('messages.payment_gateway.payment_pending_body'))
            ->warning()
            ->send();

        return redirect()->route('filament.admin.pages.subscription');
    }

    public function getPaymentGateways(): array
    {
        $gateways = [];

        if (isStripeEnabled()) {
            $gateways['stripe'] = [
                'name' => __('messages.payment_gateway.stripe_name'),
                'description' => __('messages.payment_gateway.stripe_description'),
                'icon' => 'heroicon-o-credit-card',
            ];
        }

        if (isPayPalEnabled()) {
            $gateways['paypal'] = [
                'name' => __('messages.payment_gateway.paypal_name'),
                'description' => __('messages.payment_gateway.paypal_description'),
                'icon' => 'heroicon-o-globe-alt',
            ];
        }

        if (isManualEnabled()) {
            $gateways['manual'] = [
                'name' => __('messages.payment_gateway.manual_name'),
                'description' => __('messages.payment_gateway.manual_description'),
                'icon' => 'heroicon-o-building-library',
            ];
        }

        return $gateways;
    }

    /**
     * Get formatted plan limits for display
     */
    public function getPlanLimitsDisplay(): array
    {
        if (! $this->selectedPlan) {
            return [];
        }

        $limits = [];

        // User limit
        if (isset($this->selectedPlan['user_limit'])) {
            $limits[] = $this->selectedPlan['user_limit'] > 0
                ? __('messages.payment_gateway.up_to_users', ['count' => $this->selectedPlan['user_limit']])
                : __('messages.payment_gateway.unlimited_users');
        }

        // Customer limit
        if (isset($this->selectedPlan['customer_limit'])) {
            $limits[] = $this->selectedPlan['customer_limit'] > 0
                ? __('messages.payment_gateway.up_to_customers', ['count' => $this->selectedPlan['customer_limit']])
                : __('messages.payment_gateway.unlimited_customers');
        }

        // Agent limit
        if (isset($this->selectedPlan['agent_limit'])) {
            $limits[] = $this->selectedPlan['agent_limit'] > 0
                ? __('messages.payment_gateway.up_to_agents', ['count' => $this->selectedPlan['agent_limit']])
                : __('messages.payment_gateway.unlimited_agents');
        }

        // History feature
        if (isset($this->selectedPlan['is_show_history']) && $this->selectedPlan['is_show_history']) {
            $limits[] = __('messages.payment_gateway.user_activity_history');
        }

        return $limits;
    }
}
