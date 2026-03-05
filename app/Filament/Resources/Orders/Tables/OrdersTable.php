<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('public_id')
                    ->label('Заказ')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),

                TextColumn::make('payment_status')
                    ->label('Оплата')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'pending'   => 'Ожидает оплаты',
                        'verifying' => 'Проверяем',
                        'paid'      => 'Оплачен',
                        'failed'    => 'Ошибка / отмена',
                        default     => $state ?? '—',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'paid'      => 'success',
                        'verifying' => 'info',
                        'pending'   => 'warning',
                        'failed'    => 'danger',
                        default     => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'new'        => 'Новый',
                        'cooking'    => 'Готовим',
                        'delivering' => 'В доставке',
                        'done'       => 'Завершён',
                        'canceled'   => 'Отменён',
                        default      => $state ?? '—',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'new'        => 'info',
                        'cooking'    => 'warning',
                        'delivering' => 'primary',
                        'done'       => 'success',
                        'canceled'   => 'danger',
                        default      => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('Позиций')
                    ->counts('items')
                    ->sortable(),

                TextColumn::make('items_list')
                    ->label('Состав')
                    ->getStateUsing(function ($record) {
                        return $record->items
                            ->map(function ($item) {
                                return $item->title . ' ' . (int) $item->amount . 'шт';
                            })
                            ->implode(', ');
                    })
                    ->wrap(),

                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->limit(60)
                    ->wrap()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('address')
                    ->label('Адрес')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total')
                    ->label('Итого')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2, '.', ' ') . ' ₽'),

                TextColumn::make('paid_at')
                    ->label('Оплачен')
                    ->dateTime('d.m.Y H:i')
                    ->timezone('Europe/Moscow')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->timezone('Europe/Moscow')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Обновлён')
                    ->dateTime('d.m.Y H:i')
                    ->timezone('Europe/Moscow')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                Filter::make('unseen')
                    ->label('Непросмотренные')
                    ->query(fn (Builder $query) => $query->whereNull('seen_at')),
            ])

            ->recordActions([

                // ✅ Принять: отметим просмотренным + переведём в cooking
                Action::make('accept')
                    ->label('Принять')
                    ->icon('heroicon-o-hand-raised')
                    ->color('info')
                    ->visible(fn ($record) => is_null($record->seen_at))
                    ->action(function ($record) {
                        $record->update([
                            'seen_at' => now(),
                            'status'  => $record->status === 'new' ? 'cooking' : $record->status,
                        ]);
                    }),

                Action::make('markPaid')
                    ->label('Оплачен')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->payment_status !== 'paid')
                    ->action(function ($record) {
                        $record->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);
                    }),

                Action::make('toCooking')
                    ->label('Готовим')
                    ->icon('heroicon-o-fire')
                    ->color('warning')
                    ->visible(fn ($record) => in_array($record->status, ['new'], true))
                    ->action(fn ($record) => $record->update(['status' => 'cooking'])),

                Action::make('toDelivering')
                    ->label('В доставке')
                    ->icon('heroicon-o-truck')
                    ->color('primary')
                    ->visible(fn ($record) => in_array($record->status, ['cooking'], true))
                    ->action(fn ($record) => $record->update(['status' => 'delivering'])),

                Action::make('toDone')
                    ->label('Завершён')
                    ->icon('heroicon-o-flag')
                    ->color('success')
                    ->visible(fn ($record) => in_array($record->status, ['delivering'], true))
                    ->action(fn ($record) => $record->update(['status' => 'done'])),

                Action::make('toCanceled')
                    ->label('Отменён')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== 'done')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'canceled'])),

                // ✅ Печать (открывает новую вкладку)
                Action::make('print')
                    ->label('Печать')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn ($record) => url("/admin/orders/{$record->id}/print"), true)
                    ->openUrlInNewTab(),

                EditAction::make()->label('Редакт.'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            // ✅ Подсветка непросмотренных
            ->recordClasses(fn ($record) =>
                is_null($record->seen_at)
                    ? 'bg-amber-50 dark:bg-amber-950/30'
                    : null
            )

            ->poll('5s')
            ->defaultSort('created_at', 'desc');
    }
}
