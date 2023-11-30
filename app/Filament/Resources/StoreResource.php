<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 2;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('store_id')->visibleOn(['view','edit'])->disabled()->prefixAction(CopyAction::make()),
                Forms\Components\TextInput::make('api_key')->visibleOn(['view','edit'])->disabled()->suffixAction(CopyAction::make()),
                Forms\Components\TextInput::make('business_name')->required(),
                Forms\Components\FileUpload::make('business_logo'),
                Forms\Components\TextInput::make('business_type')->required(),
                Forms\Components\TextInput::make('mobile_number')->required()->tel(),
                Forms\Components\TextInput::make('business_email')->required()->email(),
                Forms\Components\TextInput::make('domain_name')->required(),
                Forms\Components\TextInput::make('website_url')->required()->url(),
                Forms\Components\TextInput::make('server_ip')->required(),
                Forms\Components\TextInput::make('add1')->required(),
                Forms\Components\TextInput::make('add2')->required(),
                Forms\Components\TextInput::make('city')->required(),
                Forms\Components\TextInput::make('state')->required(),
                Forms\Components\TextInput::make('country')->required(),

            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store_id'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\ImageColumn::make('business_logo'),
                Tables\Columns\TextColumn::make('business_name'),
                Tables\Columns\TextColumn::make('balance'),
                Tables\Columns\BadgeColumn::make('status'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('qr_code')->label('QR')
                    ->url(fn (Store $record): string => route('store.default_payment_link_qr_code', ['store' => $record]))
                    ->openUrlInNewTab()
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
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
