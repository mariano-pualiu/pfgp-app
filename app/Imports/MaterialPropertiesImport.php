<?php

namespace App\Imports;

use App\Enums\FrameworkTypeEnum;
use App\Models\Framework;
use App\Models\Material;
use App\Models\Property;
use App\Values\EntryData;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns;
use Maatwebsite\Excel\Row;

class MaterialPropertiesImport implements Concerns\OnEachRow, Concerns\WithHeadingRow, Concerns\WithBatchInserts, Concerns\WithChunkReading/*, Concerns\WithUpserts*/
{
    public function __construct(
        protected Framework $framework
    )
    {
        //
    }

    use Concerns\Importable;

    public function onRow(Row $row)
    {
        $material = Material::firstOrCreate([
            'name'         => Arr::get($row, 'name'),
            'framework_id' => $this->framework->id
        ]);

        // 'node'        => MolecularBuildingBlock::where([
        //     'code' => Arr::get($row, 'node'),
        //     'type' => MolecularTypeEnum::NODE->value,
        // ])->first()->getAttributes(),
        // 'linker'      => MolecularBuildingBlock::where([
        //     'code' => Arr::get($row, 'linker'),
        //     'type' => MolecularTypeEnum::LINKER->value,
        // ])->first()->getAttributes(),

        $this->framework->materials()->save($material);

        $properties = $row->toCollection()->except(['name'])
            ->mapWithKeys(function ($columnValue, $columnName) use ($material) {
                $propertyData = [
                    'name'         => $columnName,
                    'framework_id' => $this->framework->id
                ];
                $entryData = [
                    'label'   => Str::of($columnName)->title()->toString(),
                    'section' => '',
                    'tooltip' => '',
                ];
                $property = Property::firstOrCreate($propertyData, ['entry' => EntryData::from($entryData)]);
                return [$property->id => ['value' => $columnValue]];
            });

        $material->properties()->sync($properties);

        return $material;
    }

    // public function uniqueBy()
    // {
    //     return 'name';
    // }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
