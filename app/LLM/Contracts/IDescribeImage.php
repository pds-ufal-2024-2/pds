<?php declare(strict_types=1);

namespace App\LLM\Contracts;

interface IDescribeImage
{
    public function imageDescription(string $base64Image): string;
}