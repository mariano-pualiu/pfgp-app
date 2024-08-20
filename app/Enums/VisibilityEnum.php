<?php

namespace App\Enums;

use App\Enums\Traits\EnumTraits;
use ArchTech\Enums\Options;

enum VisibilityEnum: string
{
    use EnumTraits;
    use Options;

    case PUBLIC     = 'public';
    case RESTRICTED = 'restricted';
    case SHARED     = 'shared';
    case PRIVATE    = 'private';

    public function description()
    {
        return match ($this) {
            VisibilityEnum::PUBLIC     => 'Any one can see it, its published to the world.',
            VisibilityEnum::RESTRICTED => 'Visibile only to the same owner\'s team.',
            VisibilityEnum::SHARED     => 'Visibile only to the owner and some othe specific user.',
            VisibilityEnum::PRIVATE    => 'No one but the owner can see it.',
            default => throw new \Exception('Unsupported visibility option', ['visibility' => $this->name]),
        };
    }
}
