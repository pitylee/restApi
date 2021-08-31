<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;

class EmployeesDeleteEventAction extends BaseAction
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
        dd('Delete: ', $this->request['payload']);
        return;
    }
}
