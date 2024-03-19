<?php

namespace App\Values;

use Spatie\LaravelData\Data;
// use Spatie\LaravelData\Optional;

class BulkModulusData extends Data
{
    public function __construct(
        public ?string $reuss,
        public ?string $voigt,
        public ?string $hill,
    )
    {
    }
}
