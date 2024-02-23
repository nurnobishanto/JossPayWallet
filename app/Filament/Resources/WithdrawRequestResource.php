<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawRequestResource\Pages;
use App\Models\Store;
use App\Models\WithdrawAccount;
use App\Models\WithdrawRequest;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;

class WithdrawRequestResource extends Resource
{
    protected static ?string $model = WithdrawRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $userStores = Store::where('user_id', $user->id)->where('status','active')->pluck('business_name', 'id')->toArray();
        $withdrawals = WithdrawAccount::where('status', 'active')
            ->where('user_id', $user->id)
            ->get(['id', 'bank_name', 'account_name']);

        $accounts = [];
        foreach ($withdrawals as $withdrawal){
            $accounts[$withdrawal->id] = $withdrawal->bank_name.' - '.$withdrawal->account_name;
        }
        $storeBalance = $userStores ? Store::find(key($userStores))->balance : 0; // Set default balance to 0
        return $form
            ->schema([
                Select::make('withdraw_account_id')
                    ->required()
                    ->label('Select Withdraw Account')
                    ->options($accounts),

                Select::make('store_id')
                    ->required()
                    ->label('Select Store')
                    ->options($userStores),

                TextInput::make('tran_id')
                    ->default(uniqid())
                    ->required()
                    ->disabled()
                    ->prefixAction(CopyAction::make()),

                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->minValue(10)
                    ->default($storeBalance),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store.business_name')->sortable(),
                Tables\Columns\TextColumn::make('tran_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('amount')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->placeholder('Filter by status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'canceled' => 'Canceled',
                        'failed' => 'Failed',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawRequests::route('/'),
            'create' => Pages\CreateWithdrawRequest::route('/create'),
            'edit' => Pages\EditWithdrawRequest::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
