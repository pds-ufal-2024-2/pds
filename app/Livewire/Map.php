<?php

namespace App\Livewire;

use Livewire\Component;

class Map extends Component
{
    public $lat;
    public $lng;

    public $showReport = false;

    public function render()
    {
        return view('livewire.map');
    }

    public function setCoordinates($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->showReport = true;
    }
}
