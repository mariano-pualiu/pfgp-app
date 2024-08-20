<?php

namespace App\Enums\Traits;

use ArchTech\Enums\Options;
use ArchTech\Enums\Values;
use Illuminate\Support\Str;

trait EnumTraits
{
    use Options, Values;

    public function nombre(string $replacement = ' '): string
    {
        return (string) Str::of($this->value)->replace('_', $replacement)->title();
    }

    public function caso(string $replacement = ' '): string
    {
        return (string) Str::of($this->name)->replace('_', $replacement)->title();
    }

    public function etiqueta(string $replacement = ' '): string
    {
        return (string) Str::of($this->name)->replace('_', $replacement)->title();
    }

    public static function opciones()
    {
        return collect(self::options())
            ->mapWithKeys(fn ($option, $name) => [self::from($option)->nombre() => $option])
            ->toArray();
    }
}
