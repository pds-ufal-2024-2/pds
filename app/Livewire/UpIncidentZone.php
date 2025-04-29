<?php

namespace App\Livewire;

use App\Models\Incident;
use App\Models\UpIncident;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UpIncidentZone extends Component
{
    public Incident $incident;

    #[Computed]
    public function up_count()
    {
        $up = UpIncident::where('incident_id', $this->incident->id)->get();
        return count($up);
    }

    #[Computed]
    public function upping_incident()
    {
        $client_token = request()->cookie('client_token');
        $up = UpIncident::where('client_token', $client_token)->where('incident_id', $this->incident->id)->first();
        return ($up !== null);
    }

    public function render()
    {
        return view('livewire.up-incident-zone');
    }

    public function upIncident()
    {
        $client_token = request()->cookie('client_token');
        $up = UpIncident::where('client_token', $client_token)->where('incident_id', $this->incident->id)->first();
        if ($up === null) {
            $up = new UpIncident();
            $up->client_token = $client_token;
            $up->incident_id = $this->incident->id;
            $up->save();
        }
    }
}
