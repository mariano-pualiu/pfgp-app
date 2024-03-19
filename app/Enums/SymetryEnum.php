<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum SymetryEnum: string
{
    use Options;

    case TRICLINIC    = 'triclinic';
    case MONOCLINIC   = 'monoclinic';
    case ORTHORHOMBIC = 'orthorhombic';
    case TETRAGONAL   = 'tetragonal';
    case TRIGONAL     = 'trigonal';
    case HEXAGONAL    = 'hexagonal';
    case CUBIC        = 'cubic';
}
