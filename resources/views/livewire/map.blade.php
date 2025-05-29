<div>
    <div class="relative h-screen w-screen">
        <div wire:ignore class="z-0 absolute w-full h-full" id="map"></div>
        <div class="z-10 absolute inset-x-0 bottom-0">
            <div class="flex justify-center pb-5">
                <button wire:click="showReportForm" type="button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Nova ocorrência</button>
            </div>
        </div>
        {{-- <div class="z-10 absolute top-0 right-0">
            {{ $lat }} {{ $lng }}
        </div> --}}
        <div wire:show="showReport" x-transition.duration.500ms class="z-10 absolute w-full h-full bg-white">
            <livewire:report :$lat :$lng />
        </div>
    </div>
</div>

@script
<script>
    const incidents = {{ Js::from($incidents) }};
    const map = L.map('map', {preferCanvas: true});
    const tile = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19});

    function onLocationError(e)
    {
        console.error(e.message);
    }

    map.on('locationerror', onLocationError);
    map.addLayer(tile);
    map.setView([-9.5557, -35.7769], 13);
    // map.locate({setView: true, maxZoom: 17});

    map.whenReady(() => {
        incidents.forEach(incident => {
            const marker = L.marker([incident.lat, incident.lng]);
            marker.bindPopup(`
                <div>
                    <span>${incident.code}</span>
                    <span>${incident.category}</span>
                </div>
            `);
            marker.addTo(map);
            marker.on('click', () => {
                Livewire.navigate(`/report/${incident.code}`);
            });
            marker.on('mouseover', () => {
                marker.openPopup();
            });
            marker.on('mouseout', () => {
                marker.closePopup();
            });
        });

        const waypoint = L.marker(map.getCenter(), {
            iteractive: false,
            zIndexOffset: 1000
        });
        const coord = waypoint.getLatLng();
        $wire.setCoordinates(coord.lat, coord.lng);
        waypoint.bindTooltip('Clique para confirmar a localização');
        waypoint.openTooltip();
        waypoint.addTo(map);
        map.on('move', () => {
            waypoint.setLatLng(map.getCenter());
            const coord = waypoint.getLatLng();
            $wire.setCoordinates(coord.lat, coord.lng);
        });
        map.on('zoom', () => {
            waypoint.setLatLng(map.getCenter());
            const coord = waypoint.getLatLng();
            $wire.setCoordinates(coord.lat, coord.lng);
        });
        waypoint.on('click', () => {
            waypoint.remove();
            map.off('move');
            map.off('zoom');
            $wire.showReportForm();
        });
    });
</script>
@endscript