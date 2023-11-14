<?php

namespace App\Filament\Resources\WithdrawRequestResource\Pages;

use App\Filament\Resources\WithdrawRequestResource;
use App\Models\Store;
use App\Models\WithdrawRequest;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateWithdrawRequest extends CreateRecord
{
    protected static string $resource = WithdrawRequestResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function handleRecordCreation(array $data): Model
    {
        $user = auth('web')->user();
        $storeId = $data['store_id'];
        $amount = $data['amount'];

        $existingRequest = WithdrawRequest::where('user_id', $user->id)
            ->where('store_id', $storeId)
            ->where('status', 'pending')
            ->first();

        $store = Store::find($storeId);

        if ($existingRequest) {
            $this->notify('danger', 'Your another withdraw request from this store is pending. Contact support');
            return WithdrawRequest::make();
        }

        else if (!$store) {
            $this->notify('danger', 'Selected store not found');
            return WithdrawRequest::make();
        }

        else if ($store->balance < $amount) {
            $this->notify('danger', 'Your withdraw amount must be equal or less than '.$store->balance);
            return WithdrawRequest::make();
        }
        else{
            $data['user_id'] = $user->id;
            return WithdrawRequest::create($data);
        }

    }

}
