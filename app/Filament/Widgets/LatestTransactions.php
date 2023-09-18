<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestTransactions extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getTableQuery(): Builder
    {
        return Transaction::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('tran_id')
                ->label('Transaction ID'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('created_at'),
        ];

    }
}
