<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class PoissonRatioData extends Data
{
    /**
     * Unit less, tensors e.g. e^xy
     */
    public function __construct(
        public ?string $exy,
        public ?string $exz,
        public ?string $eyx,
        public ?string $eyz,
        public ?string $ezx,
        public ?string $ezy,
    )
    {
    }
}
