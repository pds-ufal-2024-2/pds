<?php declare(strict_types=1);

namespace App\LLM\Models;

use App\LLM\DockerOllama;
use App\LLM\Contracts\ISelectCategory;
use App\LLM\Contracts\IShortText;
use App\LLM\Contracts\ISuggestAction;

class DeepseekR1 extends DockerOllama implements ISelectCategory, IShortText, ISuggestAction
{
    protected array $categories = [
        'Animal',
        'Vegetação',
        'Infraestrutura',
        'Poluição',
        'Outra',
    ];

    protected string $model = 'deepseek-r1';

    public function selectCategory(string $imageDescription): string
    {
        $prompt = "{$imageDescription}. A partir dessa descrição de uma imagem, selecione uma das seguintes categorias que melhor se encaixa com a descrição: " . implode(', ', $this->categories) . ". Responda apenas o nome da categoria.";
        $response = $this->request($prompt);
        $response = preg_replace('/<think>.*?<\/think>/s', '', $response); // Remove think
        $response = trim($response); // Remove blanks at the beginning and end
        return $response;
    }

    public function resumeText(string $text): string
    {
        $prompt = "Resuma o seguinte texto em até cinco palavras: {$text}. Responda apenas com o resumo.";
        $response = $this->request($prompt);
        $response = preg_replace('/<think>.*?<\/think>/s', '', $response); // Remove think
        $response = trim($response); // Remove blanks at the beginning and end
        return $response;
    }

    public function suggestAction(string $incidentDescription): string
    {
        $prompt = "A partir da seguinte descrição de um incidente: {$incidentDescription}, sugira uma ação que deve ser tomada. Responda apenas com a ação sugerida.";
        $response = $this->request($prompt);
        $response = preg_replace('/<think>.*?<\/think>/s', '', $response); // Remove think
        $response = trim($response); // Remove blanks at the beginning and end
        return $response;
    }
}
