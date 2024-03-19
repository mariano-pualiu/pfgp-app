<?php

namespace App\Models;

use App\Enums;
use App\Models\MolecularBuildingBlock;
use App\Values;
use App\Values\VelocitiesOfSoundData;
use App\Values\VolumeParametersData;
use MongoDB\Laravel\Eloquent\Model;

class Mof extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'mofs_collection';

    protected $fillable = [
        'name',
        'topology',
        'node',
        'linker',
        'space_group',
        'symmetry',
        'vectors',
        'angles',
        'pore_sizes',
        'channels',
        'area',
        'number_of_closed_pockets',
        'volume',
        'denisity',
        'num_of_open_metal_sites',
        'bulk_modulus',
        'shear_modulus',
        'compressibility',
        'young_modulus',
        'poisson_ratio',
        'velocities_of_sound',
        'lame_constant',
    ];

    protected $casts = [
        'symmetry'            => Enums\SymetryEnum::class,
        'topology'            => Enums\Topology3dEnum::class,
        // Unit Cell Params
        'vectors'             => Values\VectorsData::class,
        'angles'              => Values\AnglesData::class,

        'pore_sizes'          => Values\PoreSizesData::class,
        'channels'            => Values\ChannelsData::class,
        'area'                => Values\AreaParametersData::class,
        'volume'              => Values\VolumeParametersData::class,
        'bulk_modulus'        => Values\BulkModulusData::class,
        'shear_modulus'       => Values\ShearModulusData::class,
        'young_modulus'       => Values\YoungModulusData::class,
        'poisson_ratio'       => Values\PoissonRatioData::class,
        'velocities_of_sound' => Values\VelocitiesOfSoundData::class,
        'lame_constant'       => Values\LameConstantData::class,
    ];

    # Relationships

    public function nodeMolecule()
    {
        return $this->embedsOne(MolecularBuildingBlock::class, 'node');
    }

    public function linkerMolecule()
    {
        return $this->embedsOne(MolecularBuildingBlock::class, 'linker');
    }
}
