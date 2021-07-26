<?php

namespace App\Domain\Weather;

class Day
{
    public function __construct(
        private Condition $condition
    ) {
    }

    public function getCondition(): Condition
    {
        return $this->condition;
    }
}
