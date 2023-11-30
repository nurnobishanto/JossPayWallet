<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->required()
                    ->label('Select User')
                    ->options(User::where('id',auth()->user()->id)->pluck('name','id')->toArray())->default(auth()->user()->id),

                Select::make('store_id')
                    ->required()
                    ->label('Select Store')
                    ->options(Store::where('user_id',auth()->user()->id)->pluck('business_name','id')->toArray()),

                Forms\Components\TextInput::make('tran_id')->default(uniqid())->required()->disabled()->prefixAction(CopyAction::make()),
                Forms\Components\TextInput::make('success_url')->url()->required(),
                Forms\Components\TextInput::make('fail_url')->url()->required(),
                Forms\Components\TextInput::make('cancel_url')->url()->required(),
                Forms\Components\TextInput::make('amount')->numeric()->required()->minValue(10),
                Select::make('currency')->required()->options(['BDT','USD']),
                Forms\Components\TextInput::make('desc')->required(),
                Forms\Components\TextInput::make('cus_name')->required(),
                Forms\Components\TextInput::make('cus_email')->required()->email(),
                Forms\Components\TextInput::make('cus_add1')->required(),
                Forms\Components\TextInput::make('cus_add2')->required(),
                Forms\Components\TextInput::make('cus_city')->required(),
                Forms\Components\TextInput::make('cus_state')->required(),
                Forms\Components\TextInput::make('cus_country')->required(),
                Forms\Components\TextInput::make('cus_phone')->required(),
                Forms\Components\TextInput::make('opt_a')->nullable(),
                Forms\Components\TextInput::make('opt_b')->nullable(),
                Forms\Components\TextInput::make('opt_c')->nullable(),
                Forms\Components\TextInput::make('opt_d')->nullable(),
                Forms\Components\TextInput::make('type')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store.business_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('tran_id')->label('Trx ID')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bank_txn')->label('Bank TXN ')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('amount')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('customer_store_amount')->sortable()->searchable()->label('Store Amount'),
                Tables\Columns\TextColumn::make('desc')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('cus_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('cus_phone')->sortable()->searchable(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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
