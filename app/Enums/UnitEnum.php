<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum UnitEnum: string
{
    use Options;

    case ANGSTROM                 = 'angstrom';
    case ANGSTROM_SQUARED         = 'angstrom_squared';
    case ANGSTROM_CUBED           = 'angstrom_cubed';

    case DEGREES                  = 'degrees';

    case GIGAPASCAL               = 'gigapascal';
    case TERAPASCAL               = 'terapascal';
    case COUNT                    = 'count';

    case KILOMETERS_PER_SECOND    = 'kilometers_per_second';
    case GRAMS_PER_ANGSTROM_CUBIC = 'gramps_per_angstrom_cubic';

    public function symbol()
    {
        return match ($this) {
            Self::ANGSTROM                 => 'Å',
            Self::ANGSTROM_SQUARED         => 'Å²',
            Self::ANGSTROM_CUBED           => 'Å³',
            Self::DEGREES                  => '°',
            Self::GIGAPASCAL               => 'GPa',
            Self::TERAPASCAL               => 'TPa',
            Self::KILOMETERS_PER_SECOND    => 'km/s',
            Self::GRAMS_PER_ANGSTROM_CUBIC => 'g/Å³',
            Self::COUNT                    => '#',
            default                        => '',
        };
    }
}
