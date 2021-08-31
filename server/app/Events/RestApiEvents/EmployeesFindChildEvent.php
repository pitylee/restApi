<?php

namespace App\Events\RestApiEvents;

use App\Actions\RestApiEvents\EmployeesFindChildEventAction;
use App\Contracts\RestApiEvent;

class EmployeesFindChildEvent implements RestApiEvent
{
    /**
     * @param array $request
     * @return mixed|void
     */
    public function handle(array $request)
    {
        return EmployeesFindChildEventAction::run(['request' => $request]);
    }
}
