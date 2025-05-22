<?php declare(strict_types=1);

namespace App\LLM\Contracts;

interface IContainsRequest
{
    public function request(string $prompt, string $base64Image): string;
}