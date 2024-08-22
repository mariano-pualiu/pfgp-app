<?php

namespace App\Filament\Resources;

use App\Enums\FrameworkTypeEnum;
use App\Enums\VisibilityEnum;
use App\Filament\Resources\FrameworkResource\Pages;
use App\Filament\Resources\FrameworkResource\Pages\ManageFrameworkMaterials;
use App\Filament\Resources\FrameworkResource\RelationManagers;
use App\Imports\MaterialPropertiesImport;
use App\Models\Framework;
use App\Models\Material;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions as TablesActions;
use Filament\Tables\Columns;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

class FrameworkResource extends Resource
{
    protected static ?string $navigationGroup = 'My Collaborations';

    protected static ?string $pluralModelLabel = 'My Frameworks';

    protected static ?string $model = Framework::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Select::make('type')->options(FrameworkTypeEnum::class),
                Components\TextInput::make('name')->required()->rules(['min:5']),
                // Components\Section::make('Materials Display Details')
                //     ->schema([
                //         Components\Repeater::make('sections')
                //             ->schema([
                //                 Components\TextInput::make('name')
                //                     ->required()
                //                     ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'The name of the section that groups related values')
                //                     ->placeholder('The section\'s name'),
                //                 Components\TextInput::make('columns')
                //                     ->integer()
                //                     ->in([1, 2, 3, 4])
                //                     ->required()
                //                     ->default(3)
                //                     ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'The number of columns this section will be segmented in (1-4)')
                //                     ->placeholder('The section\'s number of columns'),

                //                 Components\Textarea::make('description')
                //                     ->required()
                //                     ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'A clarifying description for the data this section groups')
                //                     ->placeholder('A description for the section\'s data')
                //                     ->columnSpan(2),
                //             ])
                //     ])
                //     ->columns(1),

                    // Components\Select::make('visibility')
                    //     ->label("Display Visibility")
                    //     ->options(array_flip(VisibilityEnum::opciones()))
                    //     ->default(VisibilityEnum::PRIVATE)
                    //     ->selectablePlaceholder(false),
                    //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columns\TextColumn::make('type')
                //     ->state(fn (Framework $framework) => $framework->type->name)
                //     ->sortable()
                //     ->searchable(),
                // Columns\TextColumn::make('name')
                //     ->sortable()
                //     ->searchable(),
                Columns\SelectColumn::make('type')
                    ->label('Type')
                    ->sortable()
                    ->searchable()
                    ->options(FrameworkTypeEnum::class)
                    ->selectablePlaceholder(false)
                    ->searchable(),
                Columns\TextInputColumn::make('name')
                    ->sortable()
                    ->label('Name')
                    ->searchable(),
                Columns\TextColumn::make('materials_count')->counts('materials'),
                Columns\TextColumn::make('sections_count')
                    // ->tooltip(fn (Framework $framework) => Blade::render('<ol>@foreach($sections as $section)<li>{{ $section }}</li>@endforeach</ol>', ['sections' => $framework->sections->pluck('name')])),
                    // ->tooltip(fn (Framework $framework) => $framework->sections->pluck('name')),
                // Columns\SelectColumn::make('visibility')
                //     ->label('Visibility')
                //     ->options(array_flip(VisibilityEnum::opciones()))
                //     ->selectablePlaceholder(false),
            ])
            ->filters([
                SelectFilter::make('type')->options(FrameworkTypeEnum::class),
                // SelectFilter::make('visibility')->options(array_flip(VisibilityEnum::opciones())),
            ])
            ->actions([
                // TablesActions\ViewAction::make(),
                TablesActions\EditAction::make()
                    ->label('Sections')
                    ->recordTitle('Framework Sections')
                    ->icon('heroicon-o-rectangle-group')
                    ->form([
                        Components\Repeater::make('sections')
                            ->schema([
                                Components\TextInput::make('name')
                                    ->required()
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'The name of the section that groups related values')
                                    ->placeholder('The section\'s name'),
                                Components\TextInput::make('columns')
                                    ->integer()
                                    ->in([1, 2, 3, 4])
                                    ->required()
                                    ->default(3)
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'The number of columns this section will be segmented in (1-4)')
                                    ->placeholder('The section\'s number of columns'),
                                Components\Textarea::make('description')
                                    ->required()
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'A clarifying description for the data this section groups')
                                    ->placeholder('A description for the section\'s data')
                                    ->columnSpan(2),
                            ])
                    ])
                    ->stickyModalHeader()
                    ->stickyModalFooter(),
                    // ->mutateFormDataUsing(fn (Framework $record, array $data) => dd($data)),
                TablesActions\ActionGroup::make([
                    TablesActions\Action::make('properties')
                        ->label('Properties')
                        ->url(fn (Framework $framework) => route('filament.admin.resources.frameworks.properties', $framework->id))
                        ->icon('heroicon-s-adjustments-horizontal')
                        ->tooltip('View Framework\'s properties'),
                        /*->using(function (Framework $framework, array $data): Framework {
                            // dump($framework, $data);
                            $framework->update($data);

                            return $framework;
                        })*/
                    // Tables\Actions\EditAction::make()
                    //     ->label('Sections')
                    //     ->icon('heroicon-s-square-3-stack-3d')
                    //     ->form([

                    //     ]),
                    TablesActions\Action::make('view_framework_materials')
                        ->label('Materials')
                        ->icon('heroicon-s-table-cells')
                        // ->size(Enums\ActionSize::Large)
                        ->url(fn (Framework $framework) => route('filament.admin.resources.frameworks.materials', $framework->id))
                        ->tooltip('View Framework\'s materials')
                        /*->url(
                            function (Framework $framework): string {
                                return route(
                                    'filament.admin.resources.mofs.index',
                                    ['activeTab' => 'framework', '_id' => $framework->_id]
                                );
                            }
                        )*/,
                    ])
                    ->label('Content')
                    ->icon('heroicon-m-server-stack')
                    ->button(),
                TablesActions\ActionGroup::make([
                    TablesActions\Action::make('import_materials_data')
                        ->label('Upload Materials')
                        ->icon('heroicon-m-document-arrow-up')
                        ->tooltip('Upload Material Data (XLSX)')
                        ->form([
                            // Placeholder::make("Descargar layout de muestra")->content(
                            //     new HtmlString("<a target='_blank' href='/samples/lista_negra_template.xlsx'>Descargar</a>")
                            // ),
                            Components\FileUpload::make('materials_data')
                                ->label('Upload materials data in XLSX format')
                                ->required()
                                // ->visibility('private')
                                // ->acceptedFileTypes(['application/xlsx'])
                                ->preserveFilenames(),
                        ])
                        ->action(function (Framework $framework, array $data) {
                            try {
                                (new MaterialPropertiesImport(framework: $framework))
                                    ->import(Arr::get($data, 'materials_data'), 'public');
                            } catch (\Exception $exception) {
                                Notification::make()
                                    ->title($exception->getMessage())
                                    ->duration(5000)
                                    ->danger()
                                    ->persistent()
                                    ->send();
                            }
                        }),
                    TablesActions\Action::make('import_cifs')
                        ->label('Upload CIFs')
                        ->icon('heroicon-s-arrow-up-on-square-stack')
                        ->size(Enums\ActionSize::Large)
                        ->tooltip('Upload Cif Files (ZIP)')
                        ->form([
                            // Placeholder::make("Descargar layout de muestra")->content(
                            //     new HtmlString("<a target='_blank' href='/samples/lista_negra_template.xlsx'>Descargar</a>")
                            // ),
                            Components\FileUpload::make('cif_files')
                                ->label('Upload cif files in ZIP format')
                                ->required()
                                // ->visibility('private')
                                // ->acceptedFileTypes(['application/xlsx'])
                                ->preserveFilenames(),
                        ])
                        ->action(function (Framework $framework, array $data) {
                            try {
                                $zip = new \ZipArchive();

                                $fileName = Storage::disk('public')->path(Arr::get($data, 'cif_files'));

                                if ($zip->open($fileName, \ZipArchive::CREATE)!==TRUE) {
                                    exit("cannot open <$filename>\n");
                                }

                                LazyCollection::make(function () use ($zip) {
                                    for ($i = 0; $i < $zip->numFiles; $i++) {
                                        $fileName = $zip->getNameIndex($i);
                                        if ($stream = $zip->getStream($fileName)) {
                                            yield [
                                                'fileName' => $fileName,
                                                'stream' => $stream
                                            ];
                                            fclose($stream);
                                        }
                                    }
                                })->each(function (array $cifFile) use ($framework) {
                                    $cifName = Str::of(Arr::get($cifFile, 'fileName'))->beforeLast('_opt.')->toString();

                                    if ($material = Material::where('name', $cifName)->first()) {
                                        $stream = Arr::get($cifFile, 'stream');
                                        // dump($stream);
                                        $material
                                            ->addMediaFromStream($stream)
                                            ->toMediaCollection('cif-files');
                                        // $material->save();
                                    }
                                    // dd($material->getMedia('cif-files'));
                                });

                                $zip->close();
                            } catch (\Exception $exception) {
                                Notification::make()
                                    ->title($exception->getMessage())
                                    ->duration(5000)
                                    ->danger()
                                    ->persistent()
                                    ->send();
                            }
                        }),
                ])
                    ->label('Imports')
                    ->icon('heroicon-m-arrow-up-tray')
                    ->button(),
            ])
            // ->bulkActions([
            //     TablesActions\BulkActionGroup::make([
            //         TablesActions\DeleteBulkAction::make(),
            //     ]),
            // ])
            ->emptyStateHeading('No Frameworks');
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
            'index' => Pages\ListFrameworks::route('/'),
            'properties' => Pages\ManageFrameworkProperties::route('/{record}/properties'),
            'materials' => Pages\ManageFrameworkMaterials::route('/{record}/materials'),
            // 'create' => Pages\CreateFramework::route('/create'),
            // 'edit' => Pages\EditSections::route('/{record}/edit'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ManageFrameworkProperties::class,
            Pages\ManageFrameworkMaterials::class,
        ]);
    }
}
