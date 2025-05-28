<?php

namespace App\Livewire;

use App\LLM\Contracts\ISelectCategory;
use App\LLM\Contracts\IShortText;
use App\LLM\DockerOllama;
use App\LLM\ModelFactory;
use App\LLM\Models\Llava;
use App\Mail\IncidentReported;
use App\Models\Incident;
use App\Models\IncidentHistory;
use App\Models\Interested;
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

    public $photoDetailsRaw;

    public $shortTextSummary;

    public $category;

    public $receive_updates = false;

    public $email;

    public $categories = [
        'Animal',
        'Vegetação',
        'Infraestrutura',
        'Poluição',
        'Outra',
    ];

    public function render()
    {
        return view('livewire.report');
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'photo') {
            $this->processPhoto();
        }
    }

    public function submitIncident()
    {
        $incident = new Incident();
        $incident->code = Str::of(Str::random(6))->lower();
        $incident->image = Storage::url($this->photo->store('photos', 'public'));
        $incident->description = $this->photoDetailsRaw;
        $incident->incident = $this->shortTextSummary;
        $incident->category = $this->category;
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

            Mail::to($this->email)->send(new IncidentReported($incident));
        }

        // Redirect to the incident page
        return $this->redirect("/report/{$incident->code}", navigate: true);
    }

    private function processPhoto()
    {
        // Get the temporary uploaded file path
        $path = $this->photo->getRealPath();

        // Get file content and convert to base64
        $data = file_get_contents($path);
        $base64Image = base64_encode($data);

        // Retrieve the image description
        $imageModel = ModelFactory::imageModel();
        if ($imageModel instanceof Llava) {
            $imageModel = $imageModel->withTranslate(target: 'pt'); // Translate to Portuguese if needed
        }
        $this->photoDetailsRaw = $imageModel->imageDescription($base64Image);

        // Select the category
        $questionModel = ModelFactory::questionModel();
        if ($questionModel instanceof ISelectCategory) {
            $this->category = $questionModel->selectCategory($this->photoDetailsRaw);
        }

        // If the category is not set, default to 'Outra'
        if (empty($this->category)) {
            $this->category = 'Outra';
        }

        // Short text summary
        if ($questionModel instanceof IShortText) {
            $this->shortTextSummary = $questionModel->resumeText($this->photoDetailsRaw);
        }
    }
}
