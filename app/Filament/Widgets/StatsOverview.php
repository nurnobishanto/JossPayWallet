<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        return [
            Card::make('Current Balance', userTotalBalance(auth('web')->user()->id))
                ->description('Available Balance')
                ->color('success'),
            Card::make('Total Withdraw', userWithdrawAmount(auth('web')->user()->id,'success'))
                ->description('Total Withdraw')
                ->color('secondary'),
            Card::make('Pending Withdraw', userWithdrawAmount(auth('web')->user()->id,'pending'))
                ->description('Pending Withdraw')
                ->color('secondary'),
            Card::make('Total Transactions', userTransactionsAmount(auth('web')->user()->id,'success'))
                ->description('Successful Transactions')
                ->color('success'),
            Card::make('Pending Transactions', userTransactionsAmount(auth('web')->user()->id,'pending'))
                ->description('Pending Transactions')
                ->color('warning'),
        ];
    }
}
