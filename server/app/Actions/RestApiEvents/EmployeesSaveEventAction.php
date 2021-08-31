<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;

class EmployeesSaveEventAction extends BaseAction
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
        dd('Save: ', $this->request['payload']);
        return;
    }
}
