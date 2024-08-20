<?php

namespace App\Filament\Resources\FrameworkResource\Pages;

use App\Filament\Resources\FrameworkResource;
use App\Infolists\Components\JsMolDisplayEntry;
use App\Models\Material;
use App\Models\Property;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components as InfoListComponents;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ManageFrameworkMaterials extends ManageRelatedRecords
{
    protected static string $resource = FrameworkResource::class;

    protected static string $relationship = 'materials';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Materials';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        $framework = $this->getOwnerRecord();

        $highlightedPropertycolumns = $framework->highlightedProperties->map(fn ($property) => Tables\Columns\TextColumn::make('highlightedProperties.' . $property->name)
                ->label($property->entry->label)
                ->state(fn (Material $material) => $material->displaying_properties->get($property->name)->material_property->value)
                ->searchable(query: fn (Builder $query, string $search): Builder =>
                    $query->whereHas('highlightedProperties', function ($query) use ($search) {
                        $query->where('materials_properties.value', 'like', "%{$search}%");
                    })
                )
            );

        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('highlightedProperties'))
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                ...$highlightedPropertycolumns,
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                // Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Preview')
                    ->modalHeading(fn ($record) => 'Previewing: ' . Str::of($record->name)->replace('_', ' ')->title()->wrap('"')),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DissociateAction::make(),
                // Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DissociateBulkAction::make(),
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                // ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $framework = $this->getOwnerRecord();

        $infoListDisplayingSections = $this->cachedMountedTableActionRecord
            ->properties
            ->reject(fn ($property) => $property->entry->section == "")
            ->groupBy(fn ($property) => $property->entry->section)
            ->map(function ($properties, $sectionName) use ($framework) {
                [$fieldSetProperties, $properties] = $properties->partition(fn ($property) => $property->entry->fieldSet);

                $properties->transform(fn ($property)
                    => InfoListComponents\TextEntry::make('property.' . $property->name)
                        ->label($property->entry->label)
                        ->state(fn () => $property->material_property->value)
                        ->placeholder('Value not yet calculated'));

                $fieldSetProperties = $fieldSetProperties
                    ->groupBy(fn ($property) => $property->entry->fieldSet)
                    ->map(function ($fieldSet, $fieldSetName) {
                        return InfoListComponents\Fieldset::make($fieldSetName)
                            ->schema($fieldSet->map(fn ($property)
                                => InfoListComponents\TextEntry::make('property.' . $property->name)
                                    ->label($property->entry->label)
                                    ->state(fn () => $property->material_property->value)
                                    ->placeholder('Value not yet calculated')
                                )->all()
                            )
                            ->columns(3);
                    });

                $section = $framework->sections->get($sectionName);

                return InfoListComponents\Section::make($section->name)
                    ->description($section->description)
                    ->schema($properties->concat($fieldSetProperties)->all())
                    ->columns($section->columns)
                    ->aside();
            });

        return $infolist
            // ->modalHeading('Delete post')
            // ->label('Preview ' . $)
            // ->record($this->product)
            ->schema([
                InfoListComponents\Section::make('MOF JsMol')
                    ->schema([
                        JsMolDisplayEntry::make('Visualization'),
                    ]),
                ...$infoListDisplayingSections
            ]);
    }
}
