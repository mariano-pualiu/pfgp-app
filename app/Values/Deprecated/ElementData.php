<?php

namespace App\Values;

use App\Enums\ElementEnum;
use Spatie\LaravelData\Data;

class ElementData extends Data
{
    /**
     * Degrees
     */
    public function __construct(
        public ElementEnum $element,
        public int $count
    )
    {
    }
}
