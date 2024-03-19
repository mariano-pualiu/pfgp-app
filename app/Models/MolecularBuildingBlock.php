<?php

namespace App\Models;

use App\Casts\ElementsCast;
use App\Enums\MolecularTypeEnum;
use App\Values\ElementData;
use MongoDB\Laravel\Eloquent\Model;

class MolecularBuildingBlock extends Model
{
    // const SUB_INDEX = [
    //     '0' => '₀',
    //     '1' => '₁',
    //     '2' => '₂',
    //     '3' => '₃',
    //     '4' => '₄',
    //     '5' => '₅',
    //     '6' => '₆',
    //     '7' => '₇',
    //     '8' => '₈',
    //     '9' => '₉'
    // ];

    protected $connection = 'mongodb';

    protected $collection = 'mofs_molecular_building_blocks';

    protected $fillable = [
        'code',
        'elements',
        'type',
    ];

    protected $casts = [
        'type'     => MolecularTypeEnum::class,
        'elements' => ElementsCast::class,
        // 'elements' => 'collection',
    ];

    # Accessors

    public function getPresentFormulaInHtmlAttribute()
    {
        return collect($this->elements)
            ->map(fn (ElementData $data) => "{$data->element->value}<sub>{$data->count}</sub>")
            ->implode('');
    }
}
