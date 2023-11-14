<?php

namespace App\Filament\Resources\WithdrawAccountResource\Pages;

use App\Filament\Resources\WithdrawAccountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListWithdrawAccounts extends ListRecords
{
    protected static string $resource = WithdrawAccountResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        $userId = Auth::id();
        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query;
    }
}
