<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Enums\FrameworkTypeEnum;
use App\Filament\Resources\MaterialResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all'  => Tab::make(),
            'mofs' => Tab::make('MOFs')->modifyQueryUsing(fn (Builder $query) => $query->whereHas('framework', fn ($framework) => $framework->where('type', FrameworkTypeEnum::MOF))),
            'cofs' => Tab::make('COFs')->modifyQueryUsing(fn (Builder $query) => $query->whereHas('framework', fn ($framework) => $framework->where('type', FrameworkTypeEnum::COF))),
        ];
    }
}
