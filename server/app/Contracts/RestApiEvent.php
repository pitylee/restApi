<?php

namespace App\Contracts;

interface RestApiEvent
{
    /**
     * @param array $request
     * @return mixed
     */
    public function handle(array $request);
}
