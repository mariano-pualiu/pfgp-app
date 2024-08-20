<?php

namespace App\Models;

use App\Casts\SectionsCast;
use App\Enums\FrameworkTypeEnum;
use App\Enums\VisibilityEnum;
use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Framework extends Model
{
    use HasFactory;

    protected $table = 'frameworks';

    protected $fillable = [
        'type',
        'name',
        // 'visibility',
        'sections',
    ];

    protected $attributes = [
        'type'        => FrameworkTypeEnum::MOF,
        'name'        => '',
        // 'visibility'  => VisibilityEnum::PRIVATE,
        // 'shared_with' => "[]",
    ];

    protected $casts = [
        'type'           => FrameworkTypeEnum::class,
        'visibility'     => VisibilityEnum::class,
        // 'shared_with' => 'array',
        'sections'       => SectionsCast::class,
    ];

    # Accessors

    /**
     * TODO: Cache the counting result forever until materials are added or removed
     * @return [type] [description]
     */
    // public function getMaterialsCountAttribute()
    // {
    //     return $this->materials()->count();
    // }

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
