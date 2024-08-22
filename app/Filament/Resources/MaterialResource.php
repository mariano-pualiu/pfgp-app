<?php

namespace App\Filament\Resources;

use App\Enums\FrameworkTypeEnum;
use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Infolists\Components\JsMolDisplayEntry;
use App\Livewire\JsmolDisplay;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions as TablesActions;
use Filament\Tables\Columns;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MaterialResource extends Resource
{
    protected static ?string $navigationGroup = 'My Collaborations';

    protected static ?string $pluralModelLabel = 'My Materials';

    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('MOF JsMol')
                    ->schema([
                        Livewire::make(JsmolDisplay::class)->lazy(),
                        // JsMolDisplayEntry::make('Visualization'),
                    ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')
                    ->formatStateUsing(fn (string $state): string
                        => Str::of($state)->replace('_', ' ')->upper()->toString())
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('framework.type')
                    ->formatStateUsing(fn (FrameworkTypeEnum $state): string => $state->name)
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('framework.name')
            ])
            ->filters([
                SelectFilter::make('framework')->relationship('framework', 'name'),
                SelectFilter::make('framework')->relationship('framework', 'type')
            ])
            ->actions([
                TablesActions\ViewAction::make()
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Materials');
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
            'index' => Pages\ListMaterials::route('/'),
            'view'   => Pages\ViewMaterial::route('/{record}'),
            // 'create' => Pages\CreateMaterial::route('/create'),
            // 'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
