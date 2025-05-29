<?php declare(strict_types=1);

namespace App\LLM\Contracts;

interface ISuggestions
{
    public function generateSuggestionsReport(string $text): string;
}
