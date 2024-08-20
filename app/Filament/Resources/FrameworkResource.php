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
use Filament\Tables;
use Filament\Tables\Actions as TablesActions;
use Filament\Tables\Columns;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
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
                Components\Section::make('Framework Details')
                    ->schema([
                        Components\Select::make('type')->options(FrameworkTypeEnum::class),
                        Components\TextInput::make('name')->required()->rules(['min:5']),
                    ])
                    ->columns(2),
                Components\Section::make('Materials Display Details')
                    ->schema([
                        Components\Repeater::make('sections')
                            ->schema([
                                Components\TextInput::make('name')->required(),
                                Components\TextInput::make('columns')->integer()->required(),

                                Components\Textarea::make('description')->required()->columnSpan(2),
                            ])
                    ])
                    ->columns(1),

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
                Columns\TextColumn::make('type')->sortable()->searchable(),
                Columns\TextColumn::make('name')->sortable()->searchable(),
                // Columns\SelectColumn::make('type')
                //     ->label('Type')
                //     ->options(FrameworkTypeEnum::class)
                //     ->selectablePlaceholder(false),
                    // ->searchable(),
                // Columns\TextInputColumn::make('name')
                //     ->sortable()
                //     ->label('Name')
                //     ->searchable(),
                Columns\TextColumn::make('materials_count')->counts('materials'),
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
                TablesActions\EditAction::make(),
                TablesActions\Action::make('properties')
                    ->label('Properties')
                    ->url(fn (Framework $framework) => route('filament.admin.resources.frameworks.properties', $framework->id))
                    ->color('primary')
                    ->icon('heroicon-s-adjustments-horizontal'),
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
                    ->size(Enums\ActionSize::Large)
                    ->tooltip('View Framework\'s materials')
                    /*->url(
                        function (Framework $framework): string {
                            return route(
                                'filament.admin.resources.mofs.index',
                                ['activeTab' => 'framework', '_id' => $framework->_id]
                            );
                        }
                    )*/,
                TablesActions\ActionGroup::make([
                    TablesActions\Action::make('import_materials_data')
                        ->label('Upload Materials')
                        ->icon('heroicon-m-document-arrow-up')
                        ->size(Enums\ActionSize::Large)
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
                ]),
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
