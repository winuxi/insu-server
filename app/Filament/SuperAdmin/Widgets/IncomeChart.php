<?php

namespace App\Filament\SuperAdmin\Widgets;

use App\Models\Subscription;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class IncomeChart extends ChartWidget
{
    public function getHeading(): string
    {
        return __('messages.common.income').' '.__('messages.common.chart');
    }

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '400px';

    protected static string $color = 'success';

    protected function getData(): array
    {
        $months = collect();
        $incomeData = collect();
        $year = Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            // Push month name (e.g., Jan 2025)
            $months->push(Carbon::create($year, $month)->format('M'));

            // Sum income for each month
            $monthlyIncome = Subscription::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('amount');

            $incomeData->push($monthlyIncome);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => $incomeData->toArray(),
                    'borderWidth' => 2,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
