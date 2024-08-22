<?php

namespace App\Values;

use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SectionData extends Data
{
    public function __construct(
        public ?string $id = null,
        public string $name,
        public string $description,
        public int $columns = 3,
    )
    {
        $this->id ??= Str::ulid();
    }
}
