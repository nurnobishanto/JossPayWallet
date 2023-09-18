<?php

namespace App\Filament\Resources\StoreResource\Pages;

use App\Filament\Resources\StoreResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListStores extends ListRecords
{
    protected static string $resource = StoreResource::class;

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
