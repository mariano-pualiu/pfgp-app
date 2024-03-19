<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class VelocityOfSoundData extends Data
{
    /**
     * (Km/s)
     */
    public function __construct(
        public ?string $x,
        public ?string $y,
        public ?string $z,
    )
    {
    }
}
