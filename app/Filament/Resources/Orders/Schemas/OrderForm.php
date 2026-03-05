<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('public_id')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Textarea::make('comment')
                    ->columnSpanFull(),
                TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('payment_status')
                    ->required()
                    ->default('pending'),
                TextInput::make('status')
                    ->required()
                    ->default('new'),
                DateTimePicker::make('paid_at'),
            ]);
    }
}
