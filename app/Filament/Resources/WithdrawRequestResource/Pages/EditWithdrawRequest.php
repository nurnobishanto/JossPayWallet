<?php

namespace App\Filament\Resources\WithdrawRequestResource\Pages;

use App\Filament\Resources\WithdrawRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawRequest extends EditRecord
{
    protected static string $resource = WithdrawRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
