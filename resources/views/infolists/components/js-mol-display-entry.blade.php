<x-dynamic-component :component="$getEntryWrapperView()" {{-- :entry="$entry" --}}>
    <div>
        <livewire:jsmol-display
            :material_id="$getRecord()->id"
            {{-- :node="$getRecord()->nodeMolecule->code" --}}
            {{-- :linker="$getRecord()->linkerMolecule->code" --}}
        />
    </div>
</x-dynamic-component>
