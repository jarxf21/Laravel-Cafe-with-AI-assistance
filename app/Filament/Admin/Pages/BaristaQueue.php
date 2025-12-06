<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class BaristaQueue extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $title = 'Barista Queue (KDS)';

    protected static string $view = 'filament.admin.pages.barista-queue';

    protected function getViewData(): array
    {
        return [
            'orders' => \App\Models\Order::where('status', 'preparing')
                ->with('items.product')
                ->orderBy('updated_at', 'asc')
                ->get(),
        ];
    }

    public function markReady($orderId)
    {
        $order = \App\Models\Order::find($orderId);
        if ($order) {
            $order->update([
                'status' => 'ready',
                'completed_at' => now(), // Or create ready_at
            ]);
            
            // Notification could go here
            \Filament\Notifications\Notification::make()
                ->title('Order Ready')
                ->success()
                ->send();
        }
    }
}
