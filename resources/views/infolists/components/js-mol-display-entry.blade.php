<x-dynamic-component :component="$getEntryWrapperView()" {{-- :entry="$entry" --}}>
    <div>
        <livewire:jsmol-display :node="$getRecord()->nodeMolecule->code" :linker="$getRecord()->linkerMolecule->code"/>
    </div>
</x-dynamic-component>
