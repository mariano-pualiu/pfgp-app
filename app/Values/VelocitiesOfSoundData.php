<?php

namespace App\Values;

use App\Values\VelocityOfSoundData;
use Spatie\LaravelData\Data;

class VelocitiesOfSoundData extends Data
{
    /**
     * (Km/s)
     */
    public function __construct(
        public VelocityOfSoundData $_1,
        public VelocityOfSoundData $_2,
        public VelocityOfSoundData $_3,
    )
    {
    }
}
