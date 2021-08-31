<?php

namespace App\Actions\RestApiEvents;

use App\Actions\BaseAction;
use App\Exceptions\RestApiException;
use App\Models\EmployeePositions;
use App\Models\Employees;
use Carbon\Carbon;

class EmployeesSaveEventAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function rules(): array
    {
        return [
            'request' => ['required', 'array'],
            'request.metadata.api_key' => ['required', 'exists:api_keys,api_key'],
            'request.payload.name' => ['required', 'string'],
            'request.payload.position' => ['required', 'string'],
            'request.payload.superior' => ['exists:employees,name'],
            'request.payload.startDate' => ['required', 'date'],
            'request.payload.endDate' => ['date', 'nullable'],
        ];
    }

    /**
     * @return mixed|void
     */
    public function handle()
    {
        if (Employees::where('name', $this->request['payload']['name'])->count()) {
            throw new RestApiException('Employee with name "' . $this->request['payload']['name'] . '" already exists!');
        }

        return Employees::create([
            'name' => $this->request['payload']['name'],
            'position' => EmployeePositions::wherePosition($this->request['payload']['position'])->first()->id ?? null,
            'superior' => Employees::where('name', $this->request['payload']['superior'])->wherePosition('management')->first()->id,
            'startDate' => Carbon::parse($this->request['payload']['startDate'])->format('Y-m-d'),
            'endDate' => $this->request['payload']['endDate'] ? Carbon::parse($this->request['payload']['endDate'])->format('Y-m-d') : null,
        ])->toArray();
    }
}
