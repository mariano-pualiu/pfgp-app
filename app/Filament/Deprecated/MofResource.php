<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MofResource\Pages;
use App\Filament\Resources\MofResource\RelationManagers;
use App\Models\Pfgp\Materials\Mof;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MofResource extends Resource
{
    // protected static ?string $navigationGroup = 'My Collaborations';

    protected static ?string $model = Mof::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->groups(['framework.name'])
            // ->defaultGroup('framework.name')
            ->columns([
                Columns\TextColumn::make('name')
                    ->formatStateUsing(fn (string $state): string
                        => Str::of($state)->replace('_', ' ')->upper()->toString())
                    ->searchable()
                    ->sortable(),
                // Columns\TextColumn::make('framework.name')
            ])
            ->filters([
                // Filters\SelectFilter::make('framework')->options(fn ($state) => dd($state))
                // Filter::make('framework')
                //     ->label('Framework')
                //     ->form([
                //         TextInput::make('framework._id')->label('Framework')
                //     ])
                //     ->query(
                //         function (Builder $query, array $data): Builder {
                //             dd($data);
                //             $framework = Arr::get($data, 'framework');
                //             // $record = $query->when(
                //             //     $framework,
                //             //     fn (Builder $query) => $query->where('rfc->codigo', $rfc)
                //             // );

                //             return $query;
                //         }
                //     ),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMofs::route('/'),
            'create' => Pages\CreateMof::route('/create'),
            'edit' => Pages\EditMof::route('/{record}/edit'),
        ];
    }
}
