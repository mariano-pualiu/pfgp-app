<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class YoungModulusData extends Data
{
    public function __construct(
        public ?string $x,
        public ?string $y,
        public ?string $z,
    )
    {
    }
}
