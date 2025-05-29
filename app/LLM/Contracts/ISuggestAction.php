<?php declare(strict_types=1);

namespace App\LLM\Contracts;

interface ISuggestAction
{
    public function suggestAction(string $incidentDescription): string;
}