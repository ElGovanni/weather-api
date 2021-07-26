<?php

namespace App\Domain\Weather;

class Condition
{
    public function __construct(
        private string $text
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
