<?php

namespace App\Filament\Resources\WithdrawAccountResource\Pages;

use App\Filament\Resources\WithdrawAccountResource;
use App\Models\WithdrawAccount;
use App\Models\WithdrawRequest;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateWithdrawAccount extends CreateRecord
{
    protected static string $resource = WithdrawAccountResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        $user = auth('web')->user();
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';
        return WithdrawAccount::create($data);
    }
}
