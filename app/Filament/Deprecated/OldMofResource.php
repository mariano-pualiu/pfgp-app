<?php

namespace App\Filament\Resources;

use App\Enums\ElementEnum;
use App\Enums\SymetryEnum;
use App\Enums\Topology3dEnum;
use App\Enums\UnitEnum;
use App\Filament\Resources\OldMofResource\Pages;
use App\Filament\Resources\OldMofResource\RelationManagers;
use App\Infolists\Components\JsMolDisplayEntry;
use App\Models\Mof;
use Filament\Forms;
use Filament\Forms\Components as FormComponents;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components as InfoListComponents;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions as TableActions;
use Filament\Tables\Columns;
use Filament\Tables\Filters as TableFilters;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class OldMofResource extends Resource
{
    protected static ?string $model = Mof::class;

    protected static ?string $navigationLabel = 'MOFs';

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $modelLabel = 'Mof';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             FormComponents\TextInput::make('name'),
    //             FormComponents\TextInput::make('topology'),
    //             FormComponents\TextInput::make('node'),
    //             FormComponents\TextInput::make('linker'),
    //             FormComponents\TextInput::make('space_group'),
    //             FormComponents\TextInput::make('symmetry'),
    //             FormComponents\TextInput::make('channel_count'),
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100])
            ->columns([
                Columns\TextColumn::make('name')
                    ->formatStateUsing(fn (string $state): string
                        => Str::of($state)->replace('_', ' ')->upper()->toString())
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('topology')
                    ->state(fn (Mof $mof): string => Str::upper($mof->topology->value))
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('node')
                    ->state(fn (Mof $mof) => $mof->nodeMolecule->presentFormulaInHtml)
                    ->sortable()
                    ->tooltip('X is a placeholder')
                    ->html(),
                Columns\TextColumn::make('linker')
                    ->state(fn (Mof $mof) => $mof->linkerMolecule->presentFormulaInHtml)
                    ->sortable()
                    ->tooltip('X is a placeholder')
                    ->html(),
                Columns\TextColumn::make('space_group')->searchable()->sortable(),
                Columns\TextColumn::make('symmetry')
                    ->state(fn (Mof $mof) => ucfirst($mof->symmetry?->value))
                    ->searchable()->sortable(),
            ])
            ->filters([
                TableFilters\SelectFilter::make('symmetry')
                    ->options(array_map(fn ($symetryOption) => ucfirst($symetryOption), array_flip(SymetryEnum::options())))
                    ->multiple(),
                TableFilters\SelectFilter::make('node.elements.element')
                    ->options(array_map(fn ($elementOption) => ucfirst($elementOption), array_flip(ElementEnum::options())))
                    // ->attribute('node')
                    ->multiple(),
            ])
            ->actions([
                TableActions\ViewAction::make()
            ])
            ->bulkActions([
                TableActions\BulkActionGroup::make([
                    // TableActions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             Components\Section::make()
    //                 ->schema([
    //                     Components\Split::make([
    //                         Components\Grid::make(2)
    //                             ->schema([
    //                                 Components\Group::make([
    //                                     Components\TextEntry::make('name'),
    //                                     Components\TextEntry::make('topology'),
    //                                     Components\TextEntry::make('node')
    //                                         /*->badge()
    //                                         ->date()
    //                                         ->color('success')*/,
    //                                 ]),
    //                                 Components\Group::make([
    //                                     Components\TextEntry::make('linker'),
    //                                     Components\TextEntry::make('space_group'),
    //                                     Components\TextEntry::make('symmetry'),
    //                                     // Components\SpatieTagsEntry::make('tags'),
    //                                 ]),
    //                             ]),
    //                         // Components\ImageEntry::make('image')
    //                         //     ->hiddenLabel()
    //                         //     ->grow(false),
    //                     ])->from('lg'),
    //                 ]),
    //             Components\Section::make('Content')
    //                 ->schema([
    //                     // Components\TextEntry::make('content')
    //                     //     ->prose()
    //                     //     ->markdown()
    //                     //     ->hiddenLabel(),
    //                 ])
    //                 ->collapsible(),
    //         ]);
    // }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoListComponents\Section::make('MOF JsMol')
                    ->schema([
                        JsMolDisplayEntry::make('Visualization'),
                    ]),
                InfoListComponents\Section::make('MOF Details')
                    ->description('Classification MOF details.')
                    ->schema([
                        // InfoListComponents\TextEntry::make('name'),
                        InfoListComponents\TextEntry::make('topology')
                            ->state(fn (Mof $mof): string => Str::upper($mof->topology->value)),
                        InfoListComponents\TextEntry::make('node')
                            ->label('Node Formula')
                            ->state(fn (Mof $mof) => $mof->nodeMolecule->presentFormulaInHtml)
                            ->tooltip('X is a placeholder')
                            ->html(),
                        InfoListComponents\TextEntry::make('linker')
                            ->label('Linker Formula')
                            ->state(fn (Mof $mof) => $mof->linkerMolecule->presentFormulaInHtml)
                            ->tooltip('X is a placeholder')
                            ->html(),
                        InfoListComponents\TextEntry::make('space_group'),
                        InfoListComponents\TextEntry::make('symmetry')
                            ->state(fn (Mof $mof) => ucfirst($mof->symmetry->value)),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Unit Cell Paramters (' . UnitEnum::ANGSTROM->symbol() . ')')
                    ->description('Dimensions defining the smallest repeatable unit in a MOF\'s crystal lattice.')
                    ->schema([
                        InfoListComponents\TextEntry::make('vectors.a')
                            ->label('A')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('vectors.b')
                            ->label('B')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('vectors.c')
                            ->label('C')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('MOF Angles (' . UnitEnum::DEGREES->symbol() . ')')
                    ->description('Angles between bonds, influencing MOF\'s geometric structure.')
                    ->schema([
                        InfoListComponents\TextEntry::make('angles.alpha')
                            ->label('ɑ')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('angles.beta')
                            ->label('β')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('angles.gamma')
                            ->label('ɣ')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Pore Size (' . UnitEnum::ANGSTROM->symbol() . ')')
                    ->description('Dimensions of open spaces within MOF, critical for molecule adsorption capabilities.')
                    ->schema([
                        InfoListComponents\Fieldset::make('x')
                            ->schema([
                                InfoListComponents\TextEntry::make('pore_sizes.di.x')
                                    ->label('Dᵢ')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('pore_sizes.df.x')
                                    ->label('Dⱼ')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('pore_sizes.dif.x')
                                    ->label('Dᵢⱼ')
                                    ->placeholder('Value not yet calculated'),
                            ])
                            ->columns(3),

                        InfoListComponents\Fieldset::make('y')
                            ->schema([
                                InfoListComponents\TextEntry::make('pore_sizes.di.y')
                                    ->label('Dᵢ')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('pore_sizes.df.y')
                                    ->label('Dⱼ')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('pore_sizes.dif.y')
                                    ->label('Dᵢⱼ')
                                    ->placeholder('Value not yet calculated'),
                            ])
                            ->columns(3),
                        InfoListComponents\Fieldset::make('z')
                            ->schema([
                                InfoListComponents\TextEntry::make('pore_sizes.di.z')
                                    ->label('Dᵢ')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('pore_sizes.df.z')
                                    ->label('Dⱼ')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('pore_sizes.dif.z')
                                    ->label('Dᵢⱼ')
                                    ->placeholder('Value not yet calculated'),
                            ])
                            ->columns(3),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Channels (' . UnitEnum::ANGSTROM->symbol() . ')')
                    ->description('Pathways in MOF structure for molecular transport and interaction')
                    ->schema([
                        InfoListComponents\TextEntry::make('channels.channelCount')
                            ->label('Number of Channels (' . UnitEnum::COUNT->symbol() . ')')
                            ->columnSpan(3),
                        InfoListComponents\TextEntry::make('channels.channelDi')
                            ->label('Dᵢ')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('channels.channelDj')
                            ->label('Dⱼ')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('channels.channelDij')
                            ->label('Dᵢⱼ')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->columns(3)
                    ->aside(),
                InfoListComponents\Section::make('Area (' . UnitEnum::ANGSTROM_SQUARED->symbol() . ')')
                    ->description('Surface area, usually in m²/g, indicative of adsorption capacity.')
                    ->schema([
                        InfoListComponents\TextEntry::make('number_of_closed_pockets')
                            ->label('Number Of Closed Pockets (' . UnitEnum::COUNT->symbol() . ')')
                            ->columnSpan(4),
                        InfoListComponents\TextEntry::make('area.accessibleSurfaceArea')
                            ->label('Accessible Surface Area'),
                        InfoListComponents\TextEntry::make('area.nonAccessibleSurfaceArea')
                            ->label('Non Accessible Surface Area')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('area.channelSurfaceArea')
                            ->label('Channel Surface Area')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('area.pocketSurfaceArea')
                            ->label('Pocket Surface Area')
                            ->placeholder('Value not yet calculated')
                            ->bulleted()
                            ->listWithLineBreaks()
                            ->limitList(3)
                            ->expandableLimitedList()
                            // ->formatStateUsing(fn (string $state): string => '[ ' . $state . ' ]')
                            // ->listWithLineBreaks(),
                            // ->bulleted(),
                    ])
                    ->aside()
                    ->columns(4),
                InfoListComponents\Section::make('Volume (' . UnitEnum::ANGSTROM_CUBED->symbol() . ')')
                    ->description('Void volume within MOF, relevant for storage and catalysis.')
                    ->schema([
                        InfoListComponents\TextEntry::make('num_of_open_metal_sites')
                            ->label('Number of Open Metal Sites (' . UnitEnum::COUNT->symbol() . ')')
                            ->placeholder('Value not yet calculated'),

                        InfoListComponents\TextEntry::make('volume.ucVolume')
                            ->label('UC Volume')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('volume.accessibleVolume')
                            ->label('Accessible Volume')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('volume.nonAccessibleVolume')
                            ->label('Non Accessible Volume')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('volume.channelVolume')
                            ->label('Channel Volume')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('volume.probeOccupiableAccessibleVolume')
                            ->label('Probe Occupiable Accessible Volume')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('volume.probeOccupiableNonAccessibleVolume')
                            ->label('Probe Occupiable Non Accessible Volume')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('volume.pocketVolume')
                            ->label('Pocket Volume')
                            ->placeholder('Value not yet calculated')
                            ->listWithLineBreaks()
                            ->limitList(3)
                            ->expandableLimitedList(),

                        InfoListComponents\TextEntry::make('denisity')
                            ->label('Density (' . UnitEnum::GRAMS_PER_ANGSTROM_CUBIC->symbol() . ')')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Bulk Modulus (' . UnitEnum::GIGAPASCAL->symbol() . ')')
                    ->description('MOF\'s resistance to volume change under pressure.')
                    ->schema([
                        InfoListComponents\TextEntry::make('bulk_modulus.reuss')
                            ->label('Reuss')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('bulk_modulus.voigt')
                            ->label('Voigt')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('bulk_modulus.hill')
                            ->label('Hill')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Shear Modulus (' . UnitEnum::GIGAPASCAL->symbol() . ')')
                    ->description('MOF\'s deformation response to lateral forces.')
                    ->schema([
                        InfoListComponents\TextEntry::make('shear_modulus.reuss')
                            ->label('Reuss')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('shear_modulus.voigt')
                            ->label('Voigt')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('shear_modulus.hill')
                            ->label('Hill')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Young Modulus (' . UnitEnum::GIGAPASCAL->symbol() . ')')
                    ->description('Stiffness of MOF under uniaxial tension or compression.')
                    ->schema([
                        InfoListComponents\TextEntry::make('young_modulus.x')
                            ->label('x')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('young_modulus.y')
                            ->label('y')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('young_modulus.z')
                            ->label('z')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Poisson Ratio')
                    ->description('Ratio of transverse to axial strain in MOF under stress.')
                    ->schema([
                        InfoListComponents\TextEntry::make('poisson_ratio.exy')
                            ->label('exy')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('poisson_ratio.exz')
                            ->label('exz')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('poisson_ratio.eyx')
                            ->label('eyx')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('poisson_ratio.eyz')
                            ->label('eyz')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('poisson_ratio.ezx')
                            ->label('ezx')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('poisson_ratio.ezy')
                            ->label('ezy')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(3),
                InfoListComponents\Section::make('Velocity of Sound (' . UnitEnum::KILOMETERS_PER_SECOND->symbol() . ')')
                    ->description('Indicator of MOF\'s internal structural rigidity, influencing acoustic wave propagation dynamics.')
                    ->schema([
                        InfoListComponents\Fieldset::make('1')
                            ->schema([
                                InfoListComponents\TextEntry::make('velocities_of_sound._1.x')
                                    ->label('x1')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('velocities_of_sound._1.y')
                                    ->label('y1')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('velocities_of_sound._1.z')
                                    ->label('z1')
                                    ->placeholder('Value not yet calculated'),
                            ])->columns(3),
                        InfoListComponents\Fieldset::make('2')
                            ->schema([
                                InfoListComponents\TextEntry::make('velocities_of_sound._2.x')
                                    ->label('x2')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('velocities_of_sound._2.y')
                                    ->label('y2')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('velocities_of_sound._2.z')
                                    ->label('z2')
                                    ->placeholder('Value not yet calculated'),
                            ])->columns(3),
                        InfoListComponents\Fieldset::make('3')
                            ->schema([
                                InfoListComponents\TextEntry::make('velocities_of_sound._3.x')
                                    ->label('x3')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('velocities_of_sound._3.y')
                                    ->label('y3')
                                    ->placeholder('Value not yet calculated'),
                                InfoListComponents\TextEntry::make('velocities_of_sound._3.z')
                                    ->label('z3')
                                    ->placeholder('Value not yet calculated'),
                            ])->columns(3),
                    ])
                    ->aside(),
                InfoListComponents\Section::make('Lamé Properties (' . UnitEnum::GIGAPASCAL->symbol() . ')')
                    ->description('MOF\'s elastic response, particularly its resistance to shape changes under stress.')
                    ->schema([
                        InfoListComponents\TextEntry::make('lame_constant.lambda')
                            ->placeholder('Value not yet calculated'),
                        InfoListComponents\TextEntry::make('lame_constant.mu')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(2),
                InfoListComponents\Section::make('Compressibility (' . UnitEnum::TERAPASCAL->symbol() . ')')
                    ->description('MOF\'s susceptibility to volume reduction under applied pressure, indicating structural flexibility.')
                    ->schema([
                        InfoListComponents\TextEntry::make('compressibility')
                            ->label('Compressibility (' . UnitEnum::TERAPASCAL->symbol() . ')')
                            ->placeholder('Value not yet calculated'),
                    ])
                    ->aside()
                    ->columns(2),
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
            // 'view' => Pages\ViewMof::route('/{record}'),
        ];
    }    
}
