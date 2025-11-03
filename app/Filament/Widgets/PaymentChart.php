<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PaymentChart extends ChartWidget
{
    public function getHeading(): string
    {
        return __('messages.subscription.payment').' '.__('messages.common.chart');
    }

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $user = auth()->user();
        $isAgent = $user->hasRole(User::AGENT);
        $isCustomer = $user->hasRole(User::CUSTOMER);

        // Base query: payments for this year
        $query = \App\Models\InsurancePayment::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', now()->year);

        // Filter for agent: only payments from insurances handled by them
        if ($isAgent) {
            $query->whereHas('insurance', fn ($q) => $q->where('agent_id', $user->id));
        }

        // Filter for customer: only their own insurance payments
        if ($isCustomer) {
            $query->whereHas('insurance', fn ($q) => $q->where('customer_id', $user->id));
        }

        // Group payments by month
        $payments = $query->groupBy(DB::raw('MONTH(date)'))->pluck('total', 'month');

        // Fill all months with 0s by default
        $data = array_fill(1, 12, 0);
        foreach ($payments as $month => $total) {
            $data[$month] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Payments',
                    'fill' => true,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointBackgroundColor' => 'rgb(255, 99, 132)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'data' => array_values($data),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
