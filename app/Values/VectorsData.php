<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class VectorsData extends Data
{
    /**
     * Angstrom
     */
    public function __construct(
        public string $a,
        public string $b,
        public string $c,
    )
    {
    }
}
