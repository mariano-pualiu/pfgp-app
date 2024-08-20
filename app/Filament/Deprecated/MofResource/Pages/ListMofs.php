<?php

namespace App\Filament\Resources\MofResource\Pages;

use App\Filament\Resources\MofResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListMofs extends ListRecords
{
    protected static string $resource = MofResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
