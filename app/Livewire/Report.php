<?php

namespace App\Livewire;

use App\Mail\IncidentReported;
use App\Models\Incident;
use App\Models\IncidentHistory;
use App\Models\Interested;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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
        $incident->code = uniqid();
        $incident->image = $this->photo->store('photos', 'public');
        $incident->description = $this->photoDetailsRaw;
        $incident->category = $this->category;
        $incident->latitude = $this->lat;
        $incident->longitude = $this->lng;
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

        // Retrieve the image description via LLava
        $response = Http::timeout(180)->post(url: 'http://ollama:11434/api/generate', data: [
            'model' => 'llava',
            'prompt' => 'Describe the image',
            'images' => [$base64Image],
            'stream' => false,
        ]);

        $photoDetailsRaw = $response->json()['response'];

        // Translate the description to Portuguese
        $tr = new GoogleTranslate();
        $tr->setSource('en');
        $tr->setTarget('pt');

        $this->photoDetailsRaw = $tr->translate($photoDetailsRaw);

        // Select the category using the deepseek-r1 model
        $response = Http::timeout(180)->post(url: 'http://ollama:11434/api/generate', data: [
            'model' => 'deepseek-r1',
            'prompt' => "{$photoDetailsRaw}. A partir dessa descrição de uma imagem, selecione uma das seguintes categorias que melhor se encaixa com a descrição: " . implode(', ', $this->categories) . ". Responda apenas o nome da categoria.",
            'stream' => false,
        ]);

        $category = $response->json()['response'];

        // Remove all text between <think> and </think>
        $category = preg_replace('/<think>.*?<\/think>/s', '', $category);

        $this->category = trim($category);
    }
}
