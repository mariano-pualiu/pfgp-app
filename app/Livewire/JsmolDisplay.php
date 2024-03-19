<?php

namespace App\Livewire;

use App\Models\Mof;
use Livewire\Component;

class JsmolDisplay extends Component
{
    public string $node;
    public string $linker;

    public function render()
    {
        // dd($this->node, $this->linker);
        return view('livewire.jsmol-display');
    }
}
