<?php declare(strict_types=1);

namespace App\LLM;

use App\LLM\Contracts\IContainsRequest;
use Illuminate\Support\Facades\Http;

class DockerOllama implements IContainsRequest
{
    protected int $timeout = 300;
    protected string $url = 'http://ollama:11434/api/generate';
    protected string $model;

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function request(string $prompt, ?string $image = null): string
    {
        if (empty($this->model)) {
            throw new \Exception('Model not set');
        }

        $data = [
            'model' => $this->model,
            'prompt' => $prompt,
            'stream' => false,
        ];
        if ($image) {
            $data['images'] = [$image];
        }

        $response = Http::timeout($this->timeout)->post(url: $this->url, data: $data);

        return $response->json()['response'] ?? '';
    }
}