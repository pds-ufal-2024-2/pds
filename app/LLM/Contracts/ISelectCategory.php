<?php declare(strict_types=1);

namespace App\LLM\Contracts;

interface ISelectCategory
{
    public function selectCategory(string $imageDescription): string;
}