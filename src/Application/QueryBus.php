<?php

namespace App\Application;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
