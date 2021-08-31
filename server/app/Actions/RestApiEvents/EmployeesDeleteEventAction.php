<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;
use App\Models\Employees;

class EmployeesDeleteEventAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function rules(): array
    {
        return [
            'request' => ['required', 'array'],
            'request.metadata.api_key' => ['required', 'exists:api_keys,api_key'],
            'request.payload.employee_id' => ['required', 'integer', 'exists:employees,id'],
        ];
    }

    /**
     * @return mixed|void
     */
    public function handle()
    {
        $employee = Employees::where(array_filter([
            $this->request['payload']['employee_id'] ? ['id', '=', intval($this->request['payload']['employee_id'])] : null,
            $this->request['payload']['employee_name'] ? ['name', '=', trim($this->request['payload']['employee_name'])] : null,
        ]));

        return $employee->delete() ? ['message' => 'Deleted.'] : ['message' => 'Delete error.'];
    }
}
