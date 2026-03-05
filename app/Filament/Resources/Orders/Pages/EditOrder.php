<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        if (is_null($this->record->seen_at)) {
            $this->record->forceFill(['seen_at' => now()])->save();
        }
    }
}
