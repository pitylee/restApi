<?php

namespace App\Events\RestApiEvents;

use App\Actions\RestApiEvents\EmployeesUpdateEventAction;
use App\Contracts\RestApiEvent;

class EmployeesUpdateEvent implements RestApiEvent
{
    /**
     * @param array $request
     * @return mixed|void
     */
    public function handle(array $request)
    {
        EmployeesUpdateEventAction::run(['request' => $request]);
    }
}
