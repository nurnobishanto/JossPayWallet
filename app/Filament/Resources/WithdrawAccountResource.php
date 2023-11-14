<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawAccountResource\Pages;
use App\Filament\Resources\WithdrawAccountResource\RelationManagers;
use App\Models\WithdrawAccount;
use Filament\Forms;
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

class WithdrawAccountResource extends Resource
{
    protected static ?string $model = WithdrawAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('bank_name')->required(),
                TextInput::make('account_name')->required(),
                TextInput::make('account_no')->required(),
                Select::make('account_type')->required()->options(['bank'=>'Bank','mobile_bank'=>'Mobile Bank']),
                TextInput::make('branch_name'),
                TextInput::make('routing_no'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')->sortable(),
                Tables\Columns\TextColumn::make('account_name')->sortable(),
                Tables\Columns\TextColumn::make('account_no')->sortable(),
                Tables\Columns\BadgeColumn::make('account_type'),
                Tables\Columns\TextColumn::make('status')->sortable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('account_type')
                    ->placeholder('Filter by Type')
                    ->options([
                        'bank' => 'Bank',
                        'mobile_bank' => 'Mobile Bank',
                    ]),
                SelectFilter::make('status')
                    ->placeholder('Filter by status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListWithdrawAccounts::route('/'),
            'create' => Pages\CreateWithdrawAccount::route('/create'),
            'edit' => Pages\EditWithdrawAccount::route('/{record}/edit'),
        ];
    }
}
