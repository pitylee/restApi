<?php

namespace App\Factories;

use App\Events\RestApiEvents\EmployeesDeleteEvent;
use App\Events\RestApiEvents\EmployeesFindChildEvent;
use App\Events\RestApiEvents\EmployeesFindEvent;
use App\Events\RestApiEvents\EmployeesSaveEvent;
use App\Events\RestApiEvents\EmployeesUpdateEvent;
use App\Exceptions\RestApiException;
use Illuminate\Support\Manager;

class RestApiEventManager extends Manager
{
    /**
     * @return string|void
     * @throws RestApiException
     */
    public function getDefaultDriver()
    {
        throw new RestApiException('Unknown rest api event type.');
    }

    /**
     * @return EmployeesFindChildEvent
     */
    public function createEmployeesFindChildEmployeesDriver(): EmployeesFindChildEvent
    {
        return new EmployeesFindChildEvent();
    }

    /**
     * @return EmployeesFindEvent
     */
    public function createEmployeesFindDriver(): EmployeesFindEvent
    {
        return new EmployeesFindEvent();
    }

    /**
     * @return EmployeesSaveEvent
     */
    public function createEmployeesSaveDriver(): EmployeesSaveEvent
    {
        return new EmployeesSaveEvent();
    }

    /**
     * @return EmployeesUpdateEvent
     */
    public function createEmployeesUpdateDriver(): EmployeesUpdateEvent
    {
        return new EmployeesUpdateEvent();
    }

    /**
     * @return EmployeesDeleteEvent
     */
    public function createEmployeesDeleteDriver(): EmployeesDeleteEvent
    {
        return new EmployeesDeleteEvent();
    }
}
