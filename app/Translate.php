<?php declare(strict_types=1);

namespace App;

use Stichoza\GoogleTranslate\GoogleTranslate;

class Translate
{
    public function __construct(
        protected string $source = 'pt',
        protected string $target = 'en'
    ) {}

    public function source(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function target(string $target): self
    {
        $this->target = $target;
        return $this;
    }

    public function translate(string $text): string
    {
        $tr = new GoogleTranslate();
        $tr->setSource($this->source);
        $tr->setTarget($this->target);
        return $tr->translate($text);
    }
}
