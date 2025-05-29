<?php

namespace App\Livewire;

use App\Jobs\ProcessIncidentBairro;
use App\Jobs\ProcessUploadedImage;
use App\LLM\Contracts\ISelectCategory;
use App\LLM\Contracts\IShortText;
use App\LLM\DockerOllama;
use App\LLM\ModelFactory;
use App\LLM\Models\Llava;
use App\Mail\IncidentReported;
use App\Models\Incident;
use App\Models\IncidentHistory;
use App\Models\Interested;
use App\OpenStreetMaps;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Component;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Report extends Component
{
    use WithFileUploads;

    #[Reactive]
    public $lat;

    #[Reactive]
    public $lng;

    #[Validate('image')]
    public $photo;

    public $receive_updates = false;

    public $email;

    public function render()
    {
        return view('livewire.report');
    }

    public function submitIncident()
    {
        $storagePath = $this->photo->store('photos', 'public');

        $incident = new Incident();
        $incident->code = Str::of(Str::random(6))->lower();
        $incident->image = url(Storage::url($storagePath));
        $incident->latitude = $this->lat;
        $incident->longitude = $this->lng;
        $incident->status = 'open';
        $incident->save();

        $incidentHistory = new IncidentHistory();
        $incidentHistory->incident_id = $incident->id;
        $incidentHistory->message = "Incidente reportado.";
        $incidentHistory->save();

        if ($this->receive_updates && $this->email) {
            $interested = new Interested();
            $interested->incident_id = $incident->id;
            $interested->email = $this->email;
            $interested->save();

            Mail::to($this->email)->queue(new IncidentReported($incident, $storagePath));
        }

        ProcessUploadedImage::dispatch($incident, $this->photo->getRealPath());
        ProcessIncidentBairro::dispatch($incident, $this->lat, $this->lng);

        // Redirect to the incident page
        return $this->redirect("/report/{$incident->code}", navigate: true);
    }
}
