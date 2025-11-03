<?php

namespace App\Filament\Pages;

use App\Models\Plan;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class subscription extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.subscription';

    protected static ?string $title = 'messages.subscription_plan.title'; // Using __() in getTitle()

    public string $activeTab = 'monthly';

    public function mount(): void
    {
        $this->activeTab = request()->get('tab', 'monthly');
    }

    public function getTitle(): string
    {
        return __(static::$title);
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::SevenExtraLarge;
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function purchaseAction(): Action
    {
        return Action::make('purchase')
            ->label(fn (array $arguments) => currentActivePlanId() == $arguments['plan_id'] ? __('messages.subscription_plan.current_plan') : __('messages.subscription_plan.choose_payment_method'))
            ->disabled(fn (array $arguments) => currentActivePlanId() == $arguments['plan_id'])
            ->color(fn (array $arguments) => currentActivePlanId() == $arguments['plan_id'] ? 'success' : 'primary')
            ->size('lg')
            ->modal(false)
            ->action(function (array $arguments) {
                $plan = Plan::find($arguments['plan_id']);

                if (! $plan) {
                    return;
                }

                // Store selected plan data in session
                session([
                    'selected_plan' => [
                        'id' => $plan->id,
                        'title' => $plan->title,
                        'amount' => $plan->amount,
                        'interval' => $plan->interval,
                        'user_limit' => $plan->user_limit,
                        'customer_limit' => $plan->customer_limit,
                        'agent_limit' => $plan->agent_limit,
                        'is_show_history' => $plan->is_show_history,
                    ],
                ]);

                // Redirect to payment gateway selection page
                return redirect()->route('filament.admin.pages.payment-gateway');
            });
    }

    public function getSubscriptionPlans(): array
    {
        $monthlyPlans = Plan::where('interval', Plan::MONTHLY)->get();
        $yearlyPlans = Plan::where('interval', Plan::YEARLY)->get();

        return [
            'monthly' => $this->formatPlansForDisplay($monthlyPlans, 'monthly'),
            'yearly' => $this->formatPlansForDisplay($yearlyPlans, 'yearly'),
        ];
    }

    protected function formatPlansForDisplay($plans, $interval)
    {
        $formattedPlans = [];

        foreach ($plans as $plan) {
            $features = $this->generatePlanFeatures($plan);

            $planData = [
                'id' => $plan->id,
                'name' => $plan->title,
                'price' => '$'.number_format($plan->amount, 2),
                'description' => $this->generatePlanDescription($plan),
                'features' => $features,
                'user_limit' => $plan->user_limit,
                'customer_limit' => $plan->customer_limit,
                'agent_limit' => $plan->agent_limit,
                'show_history' => $plan->is_show_history,
            ];

            // Add savings calculation for yearly plans
            if ($interval === 'yearly') {
                $monthlyEquivalent = Plan::where('title', $plan->title)
                    ->where('interval', Plan::MONTHLY)
                    ->first();

                if ($monthlyEquivalent) {
                    $monthlyYearlyPrice = $monthlyEquivalent->amount * 12;
                    $savings = $monthlyYearlyPrice - $plan->amount;

                    if ($savings > 0) {
                        $planData['original_price'] = '$'.number_format($monthlyYearlyPrice, 2);
                        $planData['savings'] = __('messages.subscription_plan.save_price', ['price' => '$'.number_format($savings, 2)]);
                    }
                }
            }

            $formattedPlans[] = $planData;
        }

        return $formattedPlans;
    }

    protected function generatePlanFeatures($plan): array
    {
        $features = [];

        // Add user limit feature
        if ($plan->user_limit > 0) {
            $features[] = __('messages.payment_gateway.up_to_users', ['count' => $plan->user_limit]);
        } else {
            $features[] = __('messages.payment_gateway.unlimited_users');
        }

        // Add customer limit feature
        if ($plan->customer_limit > 0) {
            $features[] = __('messages.payment_gateway.up_to_customers', ['count' => $plan->customer_limit]);
        } else {
            $features[] = __('messages.payment_gateway.unlimited_customers');
        }

        // Add agent limit feature
        if ($plan->agent_limit > 0) {
            $features[] = __('messages.payment_gateway.up_to_agents', ['count' => $plan->agent_limit]);
        } else {
            $features[] = __('messages.payment_gateway.unlimited_agents');
        }

        // Add history feature
        if ($plan->is_show_history) {
            $features[] = __('messages.payment_gateway.user_activity_history');
        }

        // Add plan-specific features based on plan title/tier
        $additionalFeatures = $this->getAdditionalFeaturesByPlan($plan);
        $features = array_merge($features, $additionalFeatures);

        return $features;
    }

    protected function getAdditionalFeaturesByPlan($plan): array
    {
        $planTitle = strtolower($plan->title);

        return match ($planTitle) {
            'bronze' => [
                __('messages.subscription_plan.email_support'),
                __('messages.subscription_plan.basic_analytics'),
                __('messages.subscription_plan.standard_security'),
            ],
            'gold' => [
                __('messages.subscription_plan.priority_support'),
                __('messages.subscription_plan.advanced_analytics'),
                __('messages.subscription_plan.api_access'),
                __('messages.subscription_plan.team_collaboration'),
            ],
            'diamond' => [
                __('messages.subscription_plan.dedicated_support'),
                __('messages.subscription_plan.custom_integrations'),
                __('messages.subscription_plan.advanced_security'),
                __('messages.subscription_plan.sla_guarantee'),
                __('messages.subscription_plan.white_label_options'),
            ],
            'plat' => [
                __('messages.subscription_plan.premium_support'),
                __('messages.subscription_plan.advanced_reporting'),
                __('messages.subscription_plan.custom_workflows'),
                __('messages.subscription_plan.enterprise_integrations'),
            ],
            default => [
                __('messages.subscription_plan.basic_features'),
            ],
        };
    }

    protected function generatePlanDescription($plan): string
    {
        $planTitle = strtolower($plan->title);

        return match ($planTitle) {
            'bronze' => __('messages.subscription_plan.description_bronze'),
            'gold' => __('messages.subscription_plan.description_gold'),
            'diamond' => __('messages.subscription_plan.description_diamond'),
            'plat' => __('messages.subscription_plan.description_plat'),
            default => __('messages.subscription_plan.description_default'),
        };
    }

    protected function isPopularPlan($plan): bool
    {
        // Mark 'gold' plans as popular, or you can add a 'is_popular' field to your Plan model
        return strtolower($plan->title) === 'gold';
    }
}
