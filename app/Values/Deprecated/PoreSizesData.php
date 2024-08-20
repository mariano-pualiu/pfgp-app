<?php

namespace App\Values;

use App\Values\PoreSizeData;
use Spatie\LaravelData\Data;

class PoreSizesData extends Data
{
    /**
     * Pore Size:
     *     - DF: Smallest pore
     *     - DI: Largest pore
     *     - DIF: Accessible Large Pores
     * Angstrom
     */
    public function __construct(
        public PoreSizeData $di,
        public PoreSizeData $df,
        public PoreSizeData $dif,
    )
    {
    }


}
