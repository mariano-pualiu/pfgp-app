<?php

namespace App\Filament\Resources\MofResource\Pages;

use App\Filament\Resources\MofResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMof extends EditRecord
{
    protected static string $resource = MofResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
