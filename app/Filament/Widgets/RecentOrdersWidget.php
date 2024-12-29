<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Order;

class RecentOrdersWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-orders-widget';

    public $recentOrders;

    public function mount()
    {
        $this->recentOrders = Order::latest()->take(5)->get();
    }
}
