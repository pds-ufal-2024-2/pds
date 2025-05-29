<?php

namespace App\Jobs;

use App\Models\Incident;
use App\Models\IncidentHistory;
use App\OpenStreetMaps;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessIncidentBairro implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Incident $incident,
        public float $latitude,
        public float $longitude,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->incident->bairro = OpenStreetMaps::buscarBairro($this->latitude, $this->longitude);
        $this->incident->save();

        $incidentHistory = new IncidentHistory();
        $incidentHistory->incident_id = $this->incident->id;
        $incidentHistory->message = "Bairro atualizado automaticamente: {$this->incident->bairro}";
        $incidentHistory->save();
    }
}
