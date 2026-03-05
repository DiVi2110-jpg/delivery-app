<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Filament\Resources\Orders\RelationManagers;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // ✅ ДОБАВЬ

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'public_id';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    // ✅ заменяем, чтобы включить polling (по желанию)
    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table)
            ->poll('5s'); // ✅ автообновление
    }

    // ✅ ДОБАВЬ ЭТОТ МЕТОД
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('items');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
