<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChartWidget extends ChartWidget
{

    protected static ?string $heading = 'Grafik Penjualan';

    protected function getData(): array
    {
        $sales = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->where('status', 'paid')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Harian',
                    'data' => $sales->pluck('total'),
                ],
            ],
            'labels' => $sales->pluck('date'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
