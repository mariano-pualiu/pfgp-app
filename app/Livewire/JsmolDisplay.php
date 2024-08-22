<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Component;

class JsmolDisplay extends Component
{
    public Material $record;

    public function mount(Material $record): void
    {
        $this->record = $record;
    }

    public function render()
    {
        return view('livewire.jsmol-display');
    }
}
