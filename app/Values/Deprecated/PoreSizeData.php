<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class PoreSizeData extends Data
{
    /**
     * Angstrom
     */
    public function __construct(
        public ?string $x,
        public ?string $y,
        public ?string $z,
    )
    {
    }


}
