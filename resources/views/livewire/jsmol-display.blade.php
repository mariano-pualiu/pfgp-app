<div>
    {{-- Stop trying to control. --}}
    <div id="jsmol-display"></div>

    <script>
        document.addEventListener('livewire:initialized', function () {
            $(document).ready(function() {
                let Info = {
                    width: "100%",
                    height: 400,      // pixels (but it may be in percent, like "100%")
                    debug: false,
                    j2sPath: "/js/jsmol/j2s",          // only used in the HTML5 modality
                    color: "#000000",               // gray background (note this changes legacy default which was black)
                    disableJ2SLoadMonitor: false,  // only used in the HTML5 modality
                    disableInitialConsole: false, // shows a bunch of messages while the object is being built
                    addSelectrionOptions: false,
                    // serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/php/jsmol.php",
                    serverURL: "/api/materials/{{ $material_id }}",
                    use: "HTML5",     // "HTML5" or "Java" (case-insensitive)
                    readyFunction: null, // only used in the HTML5 modality
                    // script: "load /api/mofs/ums_{{-- $node --}}_{{-- $linker --}}_opt.cif"{{-- $entry->id --}},
                    // menuFile: "",
                    // serverURL: "php/jsmol.php",  // this is not applied by default; you should set this value explicitly
                    bondWidth: 8,
                    zoomScaling: 1.5,
                    pinchScaling: 2.0,
                    mouseDragFactor: 0.5,
                    touchDragFactor: 0.15,
                    multipleBondSpacing: 4,
                    // spinRateX: 0.5,
                    // spinRateY: 0.2,
                    // spinFPS: 20,
                    // spin: true,
                };
                // Info = {
                //     width: 755,
                //     height: 400,
                //     debug: false,
                //     j2sPath: "/js/jsmol/j2s",
                //     color: "0x808080",
                //     disableJ2SLoadMonitor: false,
                //     disableInitialConsole: false,
                //     addSelectionOptions: false,
                //     serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/php/jsmol.php",
                //     use: "HTML5",
                //     readyFunction: null,
                //     script: "load $caffeine"
                // }

                $("#jsmol-display").html(Jmol.getAppletHtml("jmolApplet0", Info))
            });
        //     // jmolInitialize('/js/jsmol/');

        //     // jmolApplet(400, "load mofs/ums_N109_E10_opt.cif", "0");


        //     console.log(Info);
        //     Jmol.getApplet("jmol", Info);
        });
    </script>
</div>

@push('scripts')
<script type="text/javascript" src="/js/jsmol/JSmol.min.js"></script>
{{-- <script type="text/javascript" src="/js/jsmol/js/Jmol2.js"></script> --}}

{{-- <script>
    Jmol.getApplet("myJmol")
</script> --}}
@endpush
