<?php

namespace App\Models;

use App\Casts\ElementsCast;
use App\Enums\MolecularTypeEnum;
use App\Enums\VisibilityEnum;
use App\Values\ElementData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class BuildingBlock extends Model
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

    protected $table = 'building_blocks';

    protected $fillable = [
        'code',
        'elements',
        'type',
    ];

    protected $casts = [
        'type'       => MolecularTypeEnum::class,
        'elements'   => ElementsCast::class,
        // 'visibility' => VisibilityEnum::class,
    ];

    # Accessors

    public function getPresentFormulaInHtmlAttribute()
    {
        return collect($this->elements)
            ->map(fn (ElementData $data) => "{$data->element->value}<sub>{$data->count}</sub>")
            ->implode('');
    }

    # Scopes

    public function scopePublic($query)
    {
        return $query->where('visibility', VisibilityEnum::PUBLIC);
    }

    # Relationships

    public function owner(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function materialsProperties(): Relations\MorphMany
    // {
    //     return $this->morphMany(MaterialProperty::class, 'specification');
    // }

    public function specification(): Relations\MorphTo
    {
        return $this->morphTo();
    }

}
