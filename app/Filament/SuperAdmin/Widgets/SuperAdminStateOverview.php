<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Insurance;
use App\Models\InsurancePayment;
use App\Models\Policy;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuperAdminStateOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $base = [1, 1];

        return [
            Stat::make(__('messages.payment.total').' '.__('messages.user.users_list_title'), User::whereNot('id', auth()->id())->count())->icon('heroicon-s-users')->chart($base)->color('danger'),
            Stat::make(__('messages.common.active').' '.__('messages.policy.policies'), Policy::whereHas('insurances', fn ($q) => $q->where('status', Insurance::STATUS_ACTIVE))->distinct('id')->count('id'))->icon('heroicon-s-check-badge')->chart($base)->color('warning'),
            Stat::make(__('messages.common.active').' '.__('messages.insurance.insurance'), Insurance::where('status', Insurance::STATUS_ACTIVE)->count())->icon('heroicon-s-shield-check')->chart($base)->color('success'),
            Stat::make(__('messages.payment.total').' '.__('messages.common.income'), currencySymbol().' '.InsurancePayment::where('status', InsurancePayment::PAID)->sum('amount'))->icon('heroicon-s-banknotes')->chart($base)->color('info'),
        ];
    }
}
