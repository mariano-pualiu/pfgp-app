<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class ShearModulusData extends Data
{
    public function __construct(
        public ?string $reuss,
        public ?string $voigt,
        public ?string $hill,
    )
    {
    }
}
