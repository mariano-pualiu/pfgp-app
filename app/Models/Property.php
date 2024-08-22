<?php

namespace App\Models;

use App\Values\EntryData;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Property extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
        'framework_id',
        'entry'
    ];

    protected $attributes = [
        'entry' => '{"section":null,"label":null,"tooltip":null}'
    ];

    protected $casts = [
        'entry'       => EntryData::class,
    ];

    # Relationships

    public function framework(): Relations\BelongsTo
    {
        return $this->belongsTo(Framework::class, 'framework_id');
    }

    public function materials(): Relations\BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'materials_properties')
            ->as('values')
            ->using(MaterialProperty::class)
            ->withPivot('value')
            ->withTimestamps();
    }

    public function propertyable(): Relations\MorphTo
    {
        return $this->morphTo();
    }

    # Scopes

    public function scopeHighlighted($query)
    {
        return $query->where('highlight', true);
    }
}
