<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Основное')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Название')
                        ->required()
                        ->maxLength(255),

                    Toggle::make('is_active')
                        ->label('Активен (виден на сайте)')
                        ->default(true),

                    TextInput::make('price')
                        ->label('Цена (₽)')
                        ->numeric()
                        ->minValue(0)
                        ->required(),

                    TextInput::make('sort_order')
                        ->label('Сортировка')
                        ->numeric()
                        ->minValue(0)
                        ->default(0),

                    Select::make('type')
                        ->label('Тип')
                        ->options([
                            'piece'   => 'Штучный',
                            'weight'  => 'Весовой (цена за 100г)',
                            'portion' => 'Порция',
                            'set'     => 'Сет',
                            'drink'   => 'Напиток',
                        ])
                        ->required()
                        ->default('piece'),

                    TextInput::make('unit')
                        ->label('Единица (шт, г, порция...)')
                        ->maxLength(32)
                        ->nullable(),

                    TextInput::make('portion_weight')
                        ->label('Вес порции (г)')
                        ->numeric()
                        ->minValue(0)
                        ->nullable(),
                ]),

            Section::make('Описание и фото')
                ->schema([
                    Textarea::make('description')
                        ->label('Описание')
                        ->rows(4)
                        ->nullable(),

                    FileUpload::make('image_url')
                        ->label('Фото')
                        ->image()
                        ->disk('public')
                        ->directory('products')
                        ->imageEditor()
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                            $ext  = $file->getClientOriginalExtension();

                            return $base . '-' . now()->format('YmdHis') . '.' . $ext;
                        })
                        ->helperText('Загруженный файл будет доступен на сайте через /storage/products/...'),
                ]),
        ]);
    }
}
