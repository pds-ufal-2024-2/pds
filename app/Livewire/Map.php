<?php

namespace App\Livewire;

use App\Models\Incident;
use Livewire\Component;

class Map extends Component
{
    public $lat;
    public $lng;
    public $incidents;

    public $showReport = false;

    public function render()
    {
        return view('livewire.map');
    }

    public function mount()
    {
        $this->incidents = Incident::all()->map(function ($incident) {
            return [
                'lat' => $incident->latitude,
                'lng' => $incident->longitude,
                'category' => $incident->category,
                'code' => $incident->code,
            ];
        });
    }

    public function setCoordinates($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->showReport = true;
    }
}
