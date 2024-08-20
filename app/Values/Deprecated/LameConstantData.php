<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class LameConstantData extends Data
{
    public function __construct(
        public ?string $lambda,
        public ?string $mu,
    )
    {
    }
}
