<?php

namespace App\Values;

use Spatie\LaravelData\Data;

class ChannelsData extends Data
{
    public function __construct(
        public ?string $channelCount,
        public ?array $channelDi,
        public ?array $channelDj,
        public ?array $channelDij,
    )
    {
    }
}
