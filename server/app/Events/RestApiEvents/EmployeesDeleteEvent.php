<?php

namespace App\Events\RestApiEvents;

use App\Actions\RestApiEvents\EmployeesDeleteEventAction;
use App\Contracts\RestApiEvent;

class EmployeesDeleteEvent implements RestApiEvent
{
    /**
     * @param array $request
     * @return mixed|void
     */
    public function handle(array $request)
    {
        return EmployeesDeleteEventAction::run(['request' => $request]);
    }
}
