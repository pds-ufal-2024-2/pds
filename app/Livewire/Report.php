<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Component;

class Report extends Component
{
    use WithFileUploads;

    #[Reactive]
    public $lat;

    #[Reactive]
    public $lng;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    public $photoDetailsRaw;

    public function render()
    {
        return view('livewire.report');
    }

    public function savePhoto()
    {
        // Get the temporary uploaded file path
        $path = $this->photo->getRealPath();

        // Get file content and convert to base64
        $data = file_get_contents($path);
        $base64Image = base64_encode($data);

        // Retrieve the image description via LLava
        $response = Http::post(url: 'http://ollama:11434/api/generate', data: [
            'model' => 'llava',
            'prompt' => 'Describe the image',
            'images' => [$base64Image],
            'stream' => false,
        ]);

        $this->photoDetailsRaw = $response->json()['response'];
    }
}
