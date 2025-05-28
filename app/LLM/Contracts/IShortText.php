<?php declare(strict_types=1);

namespace App\LLM\Contracts;

interface IShortText
{
    public function resumeText(string $text): string;
}
