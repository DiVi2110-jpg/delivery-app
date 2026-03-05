<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Позиции заказа';

    public function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->label('Блюдо'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Количество'),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Цена')
                    ->suffix(' ₽'),

                Tables\Columns\TextColumn::make('line_total')
                    ->label('Сумма')
                    ->suffix(' ₽'),

            ]);
    }
}
