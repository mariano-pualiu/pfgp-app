<?php

namespace App\Models;

use App\Casts\SectionsCast;
use App\Enums\FrameworkTypeEnum;
use App\Enums\VisibilityEnum;
use App\Models\Material;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Framework extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'frameworks';

    protected $fillable = [
        'type',
        'name',
        'sections',
    ];

    protected $attributes = [
        'type'        => FrameworkTypeEnum::MOF,
        'name'        => '',
        'sections'        => '[]',
    ];

    protected $casts = [
        'type'           => FrameworkTypeEnum::class,
        'sections'       => SectionsCast::class,
    ];

    # Accessors

    public function getSectionsCountAttribute()
    {
        return count($this->sections);
    }

    # Relationships

    public function owner(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materials(): Relations\HasMany
    {
        return $this->hasMany(Material::class, 'framework_id');
    }

    public function properties(): Relations\HasMany
    {
        return $this->hasMany(Property::class, 'framework_id');
    }

    public function highlightedProperties(): Relations\HasMany
    {
        return $this->properties()->highlighted();
    }
}
