<div>
    <div id="jsmol-display"></div>
</div>

@assets
<script type="text/javascript" src="/js/jsmol/JSmol.min.js"></script>
@endassets

@script
<script>
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
            use: "HTML5",     // "HTML5" or "Java" (case-insensitive)
            readyFunction: null, // only used in the HTML5 modality
            // script: "load /api/mofs/ums_{{-- $node --}}_{{-- $linker --}}_opt.cif"{{-- $entry->id --}},
            script: "load /api/materials/{{ $record->id }}.cif"{{-- $entry->id --}},
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

        $("#jsmol-display").html(Jmol.getAppletHtml("jmolApplet0", Info));
    });
</script>
@endscript
