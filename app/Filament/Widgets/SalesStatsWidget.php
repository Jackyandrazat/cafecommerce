<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesStatsWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.sales-overview-widget';

    public $totalSalesToday;
    public $totalSalesThisWeek;
    public $totalSalesThisMonth;
    public $completedOrders;
    public $pendingOrders;

    public function mount()
    {
        $this->totalSalesToday = DB::table('orders')
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'paid')
            ->sum('total_price');

        $this->totalSalesThisWeek = DB::table('orders')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('status', 'paid')
            ->sum('total_price');

        $this->totalSalesThisMonth = DB::table('orders')
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status', 'paid')
            ->sum('total_price');

        $this->completedOrders = DB::table('orders')
            ->where('status', 'paid')
            ->count();

        $this->pendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->count();
    }

    protected function getViewData(): array
    {
        return [
            'totalSalesToday' => $this->totalSalesToday,
            'totalSalesThisWeek' => $this->totalSalesThisWeek,
            'totalSalesThisMonth' => $this->totalSalesThisMonth,
            'completedOrders' => $this->completedOrders,
            'pendingOrders' => $this->pendingOrders,
        ];
    }
}
