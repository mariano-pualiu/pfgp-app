<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Material extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'materials';

    protected $fillable = [
        'name',
        'framework_id',
    ];

    # Relationships

    public function framework(): Relations\BelongsTo
    {
        return $this->belongsTo(Framework::class, 'framework_id');
    }

    public function properties(): Relations\BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'materials_properties')
            ->as('material_property')
            ->using(MaterialProperty::class)
            ->withPivot('value')
            ->withTimestamps();
    }

    public function highlightedProperties(): Relations\BelongsToMany
    {
        return $this->properties()->highlighted();
    }

    # Accessors

    public function getDisplayingPropertiesAttribute(): Collection
    {
        return $this->highlightedProperties->keyBy('name');
    }

    public function nodeMolecule(): Relations\hasOneThrough
    {
        return $this
            ->hasOneThrough(
                BuildingBlock::class,
                MaterialProperty::class,
                'material_id',
                'id',
                'id',
                'specification_id'
            )
            ->where('building_blocks.type', 'node')
            ->where('materials_properties.specification_type', BuildingBlock::class)
            ->where('properties.name', 'node')
            ->join('properties', 'materials_properties.property_id', '=', 'properties.id');
    }

    public function linkerMolecule(): Relations\hasOneThrough
    {
        return $this
            ->hasOneThrough(
                BuildingBlock::class,
                MaterialProperty::class,
                'material_id',
                'id',
                'id',
                'specification_id'
            )
            ->where('building_blocks.type', 'linker')
            ->where('materials_properties.specification_type', BuildingBlock::class)
            ->where('properties.name', 'linker')
            ->join('properties', 'materials_properties.property_id', '=', 'properties.id');
    }

    // public function linkerMolecule(): Relations\hasOneThrough
    // {
    //     return $this
    //         ->hasOneThrough(
    //             'specification',
    //             MaterialProperty::class,
    //             'material_id', // Foreign key on the pivot table (MaterialProperty)
    //             'id', // Local key on the BuildingBlock table
    //             'id', // Local key on the Material table
    //             'specification_id' // Foreign key on the MaterialProperty table
    //         )
    //         ->whereHasMorph('specification', '*', function ($query) {
    //             $query->where('name', 'edge');
    //         });
    // }

    // public function linkerMolecule(): Relations\BelongsTo
    // {
    //     return $this->belongsTo(BuildingBlock::class, 'linker_id');
    // }

    // public function buildingBlocks(): Relations\HasManyThrough
    // {
    //     return $this->hasManyThrough(
    //         BuildingBlock::class,
    //         MaterialProperty::class,
    //         'material_id', // Foreign key on the pivot table (MaterialProperty)
    //         'id', // Local key on the BuildingBlock table
    //         'id', // Local key on the Material table
    //         'building_block_id' // Foreign key on the MaterialProperty table
    //     )->whereHas('property', function ($query) {
    //         $query->whereIn('name', ['node', 'edge']);
    //     });
    // }

    # Media

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cif-files');
    }
}
