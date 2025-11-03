<?php

namespace App\Filament\Widgets;

use App\Models\Insurance;
use App\Models\Policy;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $isAgent = $user->hasRole(User::AGENT);

        // Shared variables
        $base = [1, 1];
        $stats = [];

        if ($isAgent) {
            // Agent-specific counts
            $customerCount = User::role(User::CUSTOMER)
                ->where('created_by_id', auth()->id())
                ->orWhereHas('customerInsurances', fn ($q) => $q->where('agent_id', auth()->user()->id))->count();
            $policyCount = Policy::whereHas('insurances', fn ($q) => $q->where('agent_id', $user->id))->count();
            $insuranceCount = Insurance::where('agent_id', $user->id)->count();
        } else {
            // Admin/global view
            $customerCount = User::role('customer')->count();
            $agentCount = User::role('agent')->count();
            $policyCount = Policy::count();
            $insuranceCount = Insurance::count();
        }

        // Always show these
        $stats[] = Stat::make(__('messages.payment.total').' '.__('messages.user.users_list_title'), $customerCount)
            ->icon('heroicon-s-users')
            ->chart($base)
            ->color('success');

        if (! $isAgent) {
            $stats[] = Stat::make(__('messages.payment.total').' '.__('messages.agent.agents'), $agentCount ?? 0)
                ->icon('heroicon-s-user-plus')
                ->chart($base)
                ->color('warning');
        }

        $stats[] = Stat::make(__('messages.payment.total').' '.__('messages.policy.policies'), $policyCount)
            ->icon('heroicon-s-check-badge')
            ->chart($base)
            ->color('info');

        $stats[] = Stat::make(__('messages.payment.total').' '.__('messages.insurance.insurance'), $insuranceCount)
            ->icon('heroicon-s-shield-check')
            ->chart($base)
            ->color('danger');

        return $stats;
    }
}
