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
        $userId = auth('web')->user()->id;

        return Transaction::where('user_id', $userId)->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('desc'),
            Tables\Columns\TextColumn::make('cus_phone'),
            Tables\Columns\TextColumn::make('amount')->label('Original Amount'),
            Tables\Columns\TextColumn::make('customer_store_amount')->label('Store Amount'),
            Tables\Columns\TextColumn::make('method')->label('Method'),
            Tables\Columns\TextColumn::make('tran_id')
                ->label('Trx ID'),
            Tables\Columns\TextColumn::make('bank_txn')
                ->label('Bank TXN '),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('updated_at'),
        ];

    }
}
