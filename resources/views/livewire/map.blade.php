<div>
    <div class="relative h-screen w-screen">
        <div wire:ignore class="z-0 absolute w-full h-full" id="map"></div>
        <div class="z-10 absolute inset-x-0 bottom-0">
            <button wire:click="$js.startSetWaypoint" type="button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nova ocorrência</button>
        </div>
        <div class="z-10 absolute top-0 right-0">
            {{ $lat }} {{ $lng }}
        </div>
        <div wire:show="showReport" x-transition.duration.500ms class="z-10 absolute w-full h-full bg-white">
            <livewire:report :$lat :$lng />
        </div>
    </div>
</div>

@script
<script>
    const map = L.map('map', {preferCanvas: true});
    const tile = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19});

    function onLocationError(e)
    {
        alert(e.message);
    }

    map.on('locationerror', onLocationError);
    map.addLayer(tile);
    map.locate({enableHighAccuracy: true, setView: true, maxZoom: 14});

    $js('startSetWaypoint', () => {
        const waypoint = L.marker(map.getCenter(), {
            iteractive: false,
            zIndexOffset: 1000
        }).addTo(map);
        map.on('move', () => {
            waypoint.setLatLng(map.getCenter());
        });
        map.on('zoom', () => {
            waypoint.setLatLng(map.getCenter());
        });
        waypoint.on('click', () => {
            waypoint.remove();
            map.off('move');
            map.off('zoom');
            const coord = waypoint.getLatLng();
            $wire.setCoordinates(coord.lat, coord.lng);
        });
    });
</script>
@endscript