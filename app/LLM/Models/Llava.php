<?php declare(strict_types=1);

namespace App\LLM\Models;

use App\LLM\DockerOllama;
use App\LLM\Contracts\IDescribeImage;
use App\Translate;

class Llava extends DockerOllama implements IDescribeImage
{
    protected string $model = 'llava';
    private bool $_applyTranslate = false;
    private string $_language = '';

    public function withTranslate(string $target): self
    {
        $this->_applyTranslate = true;
        $this->_language = $target;
        return $this;
    }

    public function imageDescription(string $base64Image): string
    {
        $prompt = "Briefly describe the image.";
        $response = $this->request($prompt, $base64Image);
        if ($this->_applyTranslate) {
            $response = (new Translate())->source('en')->target($this->_language)->translate($response);
            $this->_applyTranslate = false; // Reset the flag
        }
        return $response;
    }
}
