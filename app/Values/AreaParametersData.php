<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class AreaParametersData extends Data
{
    public function __construct(
        public ?string $accessibleSurfaceArea,
        public ?string $nonAccessibleSurfaceArea,
        public ?array $channelSurfaceArea,
        // public string $numberOfClosedPockets,
        public ?array $pocketSurfaceArea,
    )
    {
    }
}
