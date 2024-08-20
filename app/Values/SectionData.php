<?php

namespace App\Values;

use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SectionData extends Data
{
    // #[Computed]
    // public string $_id;

    public function __construct(
        // public string $_id,
        public string $name,
        // public string $icon,
        public string $description,
        public int $columns = 3,
        // public string $units,
    )
    {
        // $this->_id ??= Str::ulid();
    }
}
