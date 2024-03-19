<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class VolumeParametersData extends Data
{
    public function __construct(
        public ?string $ucVolume,
        // public string $denisity,
        public ?string $accessibleVolume,
        public ?string $nonAccessibleVolume,
        public ?array $channelVolume,
        public ?array $pocketVolume,
        public ?string $probeOccupiableAccessibleVolume,
        public ?string $probeOccupiableNonAccessibleVolume,
    )
    {
    }
}
