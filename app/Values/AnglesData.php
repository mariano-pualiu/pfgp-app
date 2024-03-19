<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class AnglesData extends Data
{
    /**
     * Degrees
     */
    public function __construct(
        public string $alpha,
        public string $beta,
        public string $gamma,
    )
    {
    }
}
