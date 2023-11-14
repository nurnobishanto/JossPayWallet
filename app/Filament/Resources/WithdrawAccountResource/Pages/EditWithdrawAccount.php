<?php

namespace App\Filament\Resources\WithdrawAccountResource\Pages;

use App\Filament\Resources\WithdrawAccountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawAccount extends EditRecord
{
    protected static string $resource = WithdrawAccountResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
