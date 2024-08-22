<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations;

class MaterialProperty extends Relations\Pivot
{
    use HasUlids;

    protected $table = 'materials_properties';

    public function material(): Relations\BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function property(): Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function specification(): Relations\MorphTo
    {
        return $this->morphTo();
    }

    protected $fillable = [
        'value'
    ];
}
