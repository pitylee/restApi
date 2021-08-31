<?php

namespace App\Events\RestApiEvents;

use App\Actions\RestApiEvents\EmployeesSaveEventAction;
use App\Contracts\RestApiEvent;

class EmployeesSaveEvent implements RestApiEvent
{
    /**
     * @param array $request
     * @return mixed|void
     */
    public function handle(array $request)
    {
        EmployeesSaveEventAction::run(['request' => $request]);
    }
}
