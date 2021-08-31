<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;
use App\Exceptions\RestApiException;
use App\Models\Employees;

class EmployeesFindEventAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function rules(): array
    {
        return [
            'request' => ['required', 'array'],
            'request.metadata.api_key' => ['required', 'exists:api_keys,api_key']
        ];
    }

    /**
     * @return mixed|void
     */
    public function handle()
    {
        $position = $this->request['payload']['position'] ?? null;

        if (!$position) {
            throw new RestApiException('Position is needed in the payload!');
        }

        $employees = Employees::wherePosition($position);

        return $employees ? $employees->get()->toArray() : [];
    }
}
