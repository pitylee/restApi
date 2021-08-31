<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;
use App\Exceptions\RestApiException;
use App\Models\EmployeePositions;
use App\Models\Employees;
use Carbon\Carbon;

class EmployeesUpdateEventAction extends BaseAction
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
            'request.payload.name' => ['string'],
            'request.payload.position' => ['string'],
            'request.payload.superior' => ['exists:employees,name'],
            'request.payload.startDate' => ['date'],
            'request.payload.endDate' => ['date', 'nullable'],
        ];
    }

    /**
     * @return mixed|void
     */
    public function handle()
    {
        $employee = Employees::find($this->request['payload']['employee_id']);

        if (!$employee->count()) {
            throw new RestApiException('Employee with id "' . $this->request['payload']['employee_id'] . '" not found!');
        }

        $updates = [];

        if ($this->request['payload']['name'] ?? false) {
            $updates['name'] = trim($this->request['payload']['name']);
        }

        if ($this->request['payload']['position'] ?? false) {
            if (!$updates['position'] = EmployeePositions::wherePosition($this->request['payload']['position'])->first()->id ?? false) {
                throw new RestApiException('Employee position "' . $this->request['payload']['position'] . '" not found!');
            }
        }

        if ($this->request['payload']['superior'] ?? false) {
            if (!$updates['superior'] = Employees::where('name', $this->request['payload']['superior'])->wherePosition('management')->first()->id ?? false) {
                throw new RestApiException('Superior "' . $this->request['payload']['superior'] . '" not found!');
            }
            ;
        }

        if ($this->request['payload']['startDate'] ?? false) {
            $updates['startDate'] = Carbon::parse($this->request['payload']['startDate'])->format('Y-m-d');
        }

        if ($this->request['payload']['endDate'] ?? false) {
            $updates['endDate'] = Carbon::parse($this->request['payload']['endDate'])->format('Y-m-d');
        }

        return $employee->update($updates) ? ['message'=>'Updated.'] : ['message'=>'Update error.'];
    }
}
