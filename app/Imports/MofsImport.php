<?php

namespace App\Imports;

use App\Enums\MolecularTypeEnum;
use App\Models\Mof;
use App\Models\MolecularBuildingBlock;
use App\Values\AnglesData;
use App\Values\AreaParametersData;
use App\Values\BulkModulusData;
use App\Values\ChannelsData;
use App\Values\LameConstantData;
use App\Values\PoissonRatioData;
use App\Values\PoreSizeData;
use App\Values\PoreSizesData;
use App\Values\ShearModulusData;
use App\Values\VectorsData;
use App\Values\VelocitiesOfSoundData;
use App\Values\VelocityOfSoundData;
use App\Values\VolumeParametersData;
use App\Values\YoungModulusData;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class MofsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading/*, WithLimit*/
{
    use Importable;

    // public function limit(): int
    // {
    //     return 10;
    // }

    public function model(array $row)
    {
        unset($row[0]);
        // dump(Arr::only($row, ['node', 'linker']));
        $mofData = [
            'name'        => Arr::get($row, 'name'),
            'topology'    => Arr::get($row, 'topology'),
            'node'        => MolecularBuildingBlock::where([
                'code' => Arr::get($row, 'node'),
                'type' => MolecularTypeEnum::NODE->value,
            ])->first()->getAttributes(),
            'linker'      => MolecularBuildingBlock::where([
                'code' => Arr::get($row, 'linker'),
                'type' => MolecularTypeEnum::LINKER->value,
            ])->first()->getAttributes(),
            'space_group' => Arr::get($row, 'space_group'),
            'symmetry'    => Arr::get($row, 'symmetry'),

            'vectors'     => VectorsData::from([
                'a' => Arr::get($row, 'a_ang'),
                'b' => Arr::get($row, 'b_ang'),
                'c' => Arr::get($row, 'c_ang'),
            ]),
            'angles'      => AnglesData::from(Arr::only($row, ['alpha', 'beta', 'gamma'])),

            'pore_sizes' => PoreSizesData::from([
                'di'          => PoreSizeData::from([
                    'x' => Arr::get($row, 'di_in_x'),
                    'y' => Arr::get($row, 'di_in_y'),
                    'z' => Arr::get($row, 'di_in_z'),
                ]),
                'df'          => PoreSizeData::from([
                    'x' => Arr::get($row, 'df_in_x'),
                    'y' => Arr::get($row, 'df_in_y'),
                    'z' => Arr::get($row, 'df_in_z'),
                ]),
                'dif'          => PoreSizeData::from([
                    'x' => Arr::get($row, 'dif_in_x'),
                    'y' => Arr::get($row, 'dif_in_y'),
                    'z' => Arr::get($row, 'dif_in_z'),
                ]),
            ]),
            'channels'    => ChannelsData::from([
                'channelCount' => Arr::get($row, 'channel_count'),
                'channelDi'    => json_decode(Str::of(Arr::get($row, 'channel_di'))->replace('\'', '"')->toString()),
                'channelDj'    => json_decode(Str::of(Arr::get($row, 'channel_dj'))->replace('\'', '"')->toString()),
                'channelDij'   => json_decode(Str::of(Arr::get($row, 'channel_dij'))->replace('\'', '"')->toString()),
            ]),
            'area'        => AreaParametersData::from([
                'accessibleSurfaceArea'    => Arr::get($row, 'accessible_surface_area_a2'),
                'nonAccessibleSurfaceArea' => Arr::get($row, 'non_accessible_surface_area_a2'),
                'channelSurfaceArea'       => json_decode(Str::of(Arr::get($row, 'channel_surface_area_a2'))->replace('\'', '"')->toString()),
                'pocketSurfaceArea'        => json_decode(Str::of(Arr::get($row, 'pocket_surface_area_a2'))->replace('\'', '"')->toString()),
            ]),
            'number_of_closed_pockets' => Arr::get($row, 'number_of_closed_pockets'),
            'volume'      => VolumeParametersData::from([
                'ucVolume'                           => Arr::get($row, 'uc_volume_a3'),
                'accessibleVolume'                   => Arr::get($row, 'accessible_volume_a3'),
                'nonAccessibleVolume'                => Arr::get($row, 'non_accessible_volume_a3'),
                'channelVolume'                      => json_decode(Str::of(Arr::get($row, 'channel_volume_a3'))->replace('\'', '"')->toString()),
                'pocketVolume'                       => json_decode(Str::of(Arr::get($row, 'pocket_volume_a3'))->replace('\'', '"')->toString()),
                'probeOccupiableAccessibleVolume'    => Arr::get($row, 'probe_occupiable_accessible_volume_a3'),
                'probeOccupiableNonAccessibleVolume' => Arr::get($row, 'probe_occupiable_non_accessible_volume_a3'),
            ]),
            'denisity'                 => Arr::get($row, 'denisity'),
            'num_of_open_metal_sites'  => Arr::get($row, 'num_of_open_metal_sites'),
            'bulk_modulus'             => BulkModulusData::from([
                'reuss'  => Arr::get($row, 'bulk_modulus_reuss_gpa'),
                'voigt'  => Arr::get($row, 'bulk_modulus_voigt_gpa'),
                'hill'   => Arr::get($row, 'bulk_modulus_hill_gpa'),
            ]),
            'shear_modulus'            => ShearModulusData::from([
                'reuss'  => Arr::get($row, 'shear_modulus_reuss_gpa'),
                'voigt'  => Arr::get($row, 'shear_modulus_voigt_gpa'),
                'hill'   => Arr::get($row, 'shear_modulus_hill_gpa'),
            ]),
            'compressibility' => Arr::get($row, 'compressibility_1tpa'),
            'young_modulus'   => YoungModulusData::from([
                'x' => Arr::get($row, 'young_modulus_x_gpa'),
                'y' => Arr::get($row, 'young_modulus_y_gpa'),
                'z' => Arr::get($row, 'young_modulus_z_gpa'),
            ]),
            'poisson_ratio' => PoissonRatioData::from([
                'exy' => Arr::get($row, 'poisson_ratio_exy'),
                'exz' => Arr::get($row, 'poisson_ratio_exz'),
                'eyx' => Arr::get($row, 'poisson_ratio_eyx'),
                'eyz' => Arr::get($row, 'poisson_ratio_eyz'),
                'ezx' => Arr::get($row, 'poisson_ratio_ezx'),
                'ezy' => Arr::get($row, 'poisson_ratio_ezy'),
            ]),
            'velocities_of_sound' => VelocitiesOfSoundData::from([
                '_1' => VelocityOfSoundData::from([
                    'x' => Arr::get($row, 'velocity_of_sound_x1_kms'),
                    'y' => Arr::get($row, 'velocity_of_sound_y1_kms'),
                    'z' => Arr::get($row, 'velocity_of_sound_z1_kms'),
                ]),
                '_2' => VelocityOfSoundData::from([
                    'x' => Arr::get($row, 'velocity_of_sound_x2_kms'),
                    'y' => Arr::get($row, 'velocity_of_sound_y2_kms'),
                    'z' => Arr::get($row, 'velocity_of_sound_z2_kms'),
                ]),
                '_3' => VelocityOfSoundData::from([
                    'x' => Arr::get($row, 'velocity_of_sound_x3_kms'),
                    'y' => Arr::get($row, 'velocity_of_sound_y3_kms'),
                    'z' => Arr::get($row, 'velocity_of_sound_z3_kms'),
                ]),
            ]),
            'lame_constant' => LameConstantData::from([
                'lambda' => Arr::get($row, 'lame_constant_lambda_gpa'),
                'mu'     => Arr::get($row, 'lame_constant_mu_gpa'),
            ]),
        ];

        // dd($mofData);

        $mof = new Mof($mofData);

        return $mof;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
