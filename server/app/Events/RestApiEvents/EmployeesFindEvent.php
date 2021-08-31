<?php

namespace App\Events\RestApiEvents;

use App\Actions\RestApiEvents\EmployeesFindEventAction;
use App\Contracts\RestApiEvent;

class EmployeesFindEvent implements RestApiEvent
{
    /**
     * @param array $request
     * @return mixed|void
     */
    public function handle(array $request)
    {
        return EmployeesFindEventAction::run(['request' => $request]);
    }
}
