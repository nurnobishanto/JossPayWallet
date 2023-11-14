<?php

namespace App\Filament\Widgets;

use App\Models\WithdrawRequest;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestWithdrawRequests extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getTableQuery(): Builder
    {
        $userId = auth('web')->user()->id;

        return WithdrawRequest::where('user_id', $userId)->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('tran_id')
                ->label('WithdrawRequest ID'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('created_at'),
        ];

    }
}
