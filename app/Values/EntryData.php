<?php

namespace App\Values;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
* InfoListComponents\TextEntry::make('area.pocketSurfaceArea')
    ->label($entry->label)
    ->placeholder($entry->placeholder)
    ->bulleted()
    ->listWithLineBreaks()
    ->limitList(3)
    ->expandableLimitedList()
*/

class EntryData extends Data
{
    public function __construct(
        public ?string $section = null,
        public string $label,
        public string $tooltip,
        public ?string $fieldSet = null,
        // public string $decimalPlaces,
    )
    {
    }
}
