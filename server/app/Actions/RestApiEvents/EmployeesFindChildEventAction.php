<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;
use App\Exceptions\RestApiException;
use App\Models\Employees;

class EmployeesFindChildEventAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function rules(): array
    {
        return [
            'request' => ['required', 'array'],
            'request.metadata.api_key' => ['required', 'exists:api_keys,api_key'],
            'request.payload.parent_id' => ['numeric', 'exists:employees,id'],
            'request.payload.parent_name' => ['string'],
        ];
    }

    /**
     * @return mixed|void
     */
    public function handle()
    {
        $managerId = $this->request['payload']['parent_id'] ?? null;
        $managerName = $this->request['payload']['parent_name'] ?? null;

        if (is_null($managerId) && is_null($managerName)) {
            throw new RestApiException('Either the manager\'s ID or name is required in the payload!');
        }

        $employees = Employees::whereManager([
            'id' => $managerId,
            'name' => $managerName,
        ]);

        return $employees ? $employees->get()->toArray() : [];
    }
}
