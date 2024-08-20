<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class FieldsetData extends Data
{    public function __construct(
        public string $label,
        public int $columns = 1,
    )
    {
    }
}
