<?php

namespace App\Filament\Resources\FrameworkResource\Pages;

use App\Filament\Resources\FrameworkResource;
use App\Models\Framework;
use App\Models\Property;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageFrameworkProperties extends ManageRelatedRecords
{
    protected static string $resource = FrameworkResource::class;

    protected static string $relationship = 'properties';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function getNavigationLabel(): string
    // {
    //     $framework = Framework::find(request()->route('record'));

    //     return ($framework ? $framework->name . ' ' : '') . 'Properties';
    // }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Property Name')->searchable(),
                Tables\Columns\TextInputColumn::make('entry->label')
                    ->label('Display Label')
                    ->state(fn (Property $property) => $property->entry->label)
                    ->searchable(),
                Tables\Columns\SelectColumn::make('entry->section')
                    ->label('Display Section')
                    ->state(fn (Property $property) => $property->entry->section)
                    ->options(fn (): array => $this->getOwnerRecord()->sections->pluck('name', 'id')->toArray())
                    ->placeholder('Select a Section')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('entry->tooltip')
                    ->label('Display tooltip')
                    ->state(fn (Property $property) => $property->entry->tooltip)
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('entry->fieldSet')
                    ->label('Field Set')
                    ->state(fn (Property $property) => $property->entry->fieldSet)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('highlight')
                    ->label('Show in table')
                    ->tooltip('Display in the materials table')
                    // ->state(fn (Property $property) => $property->entry->tooltip)
                    /*->searchable()*/,
                // Columns\TextInputColumn::make('name')
                //     ->sortable()
                //     ->label('Field Name')
                //     ->searchable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
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
                //     // Tables\Actions\RestoreBulkAction::make(),
                //     // Tables\Actions\ForceDeleteBulkAction::make(),
                // ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
