<?php

namespace App\Enums;

use App\Enums\Traits\EnumTraits;
use ArchTech\Enums;

enum FrameworkTypeEnum: string
{
    use Enums\Options;
    use Enums\Names;
    use EnumTraits;

    case MOF     = 'mof';
    case COF     = 'cof';
    case ZIF     = 'zif';
    case ZEOLITE = 'zeolite';
    case POP     = 'pop';
    case SOF     = 'sof';
}
