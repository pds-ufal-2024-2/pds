<?php

namespace App\Livewire;

use App\Models\Incident as ModelsIncident;
use Livewire\Component;

class ShowIncident extends Component
{
    public ModelsIncident $incident;

    public function render()
    {
        return view('livewire.show-incident');
    }
}
