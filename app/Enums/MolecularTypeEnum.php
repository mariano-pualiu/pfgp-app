<?php

namespace App\Enums;

use App\Enums\MetaProperties\Abbr;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Options;

#[Meta(Abbr::class)]
enum MolecularTypeEnum: string
{
    use Options, Metadata;

    #[Abbr('N')]
    case NODE = 'node';

    #[Abbr('E')]
    case EDGE = 'edge';

    #[Abbr('L')]
    case LINKER = 'linker';
}
