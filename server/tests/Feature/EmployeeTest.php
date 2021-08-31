<?php

namespace Tests\Feature;

use App\Actions\RestApiComputeHmacSignatureAction;
use App\Exceptions\RestApiException;
use App\Exceptions\EmployeeException;
use App\Exceptions\ActionValidationException;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use App\Models\Employees;

class EmployeeApiTest extends TestCase
{
    /**
     * @var string
     */
    private $api_key;

    /**
     * Tests setup
     */
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2021-08-31 11:10:00');
        $this->api_key = 'asd';

        if (!Employees::find(1)) {
            Employees::insert([
                'id' => 1,
                'name' => 'Test Test',
                'position' => 2,
                'superior' => null,
                'startDate' => Carbon::now(),
                'endDate' => Carbon::now(),
            ]);
        }
    }

    /**
     * Find Employees by position.
     *
     * @return void
     */
    public function test_employee_find_by_position()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.find',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'position' => 'developer',
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertCount(collect($responseJson)->count(), $responseJson);
    }

    /**
     * Test non-existent position on Employee find.
     *
     * @return void
     */
    public function test_non_existent_position_on_employee_find()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.find',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'position' => md5(time()),
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['exception']) && $responseJson['exception'] === EmployeeException::class);
    }

    /**
     * Find Employees by position.
     *
     * @return void
     */
    public function test_employees_find_by_superior_id()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.find.child.employees',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'parent_id' => 1,
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertFalse(isset($responseJson['exception']) && $responseJson['exception'] === EmployeeException::class);
        $this->assertCount(collect($responseJson)->count(), $responseJson);
    }

    /**
     * Find Employees by position.
     *
     * @return void
     */
    public function test_employees_exception_on_find_by_superior_name_missing_id()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.find.child.employees',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'parent_name' => 'Test  Test',
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['exception']) && $responseJson['exception'] === EmployeeException::class);
    }

    /**
     * Test Employee save.
     *
     * @return void
     */
    public function test_employee_save()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.save',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'name' => 'Test Test',
                'position' => 'developer',
                'superior' => 'Delightful Dog',
                'startDate' => '2021-09-01',
                'endDate' => null,
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        Employees::where('name', $payload['payload']['name'])->delete();

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['id']) && is_numeric($responseJson['id']));
    }

    /**
     * Test Employee save when Employee with name already exists.
     *
     * @return void
     */
    public function test_exception_on_employee_save_duplicate()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.save',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'name' => 'Test Test',
                'position' => 'developer',
                'superior' => 'Delightful Dog',
                'startDate' => '2021-09-01',
                'endDate' => null,
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        //First create it so it duplicates
        $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['exception']) && $responseJson['exception'] === RestApiException::class);
    }

    /**
     * Test Employee update.
     *
     * @return void
     */
    public function test_employee_update()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.update',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'employee_id' => 1,
                'name' => 'Test Up Test',
                'position' => 'management',
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['message']) && $responseJson['message'] === 'Updated.');
    }

    /**
     * Test Employee id missing from update payload.
     *
     * @return void
     */
    public function test_exception_when_employee_update_is_missing_employee_id()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.update',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'name' => 'Test Up Test',
                'position' => 'management',
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['exception']) && $responseJson['exception'] === ActionValidationException::class);
    }

    /**
     * Test non-existent position given for Employee update payload.
     *
     * @return void
     */
    public function test_exception_when_non_existent_position_is_given_for_update_payload()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.update',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'employee_id' => 1,
                'name' => 'Test Up Test',
                'position' => 'managment',
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['exception']) && $responseJson['exception'] === RestApiException::class);
    }

    /**
     * Test delete Employee with given employee_id.
     *
     * @return void
     */
    public function test_delete_employee()
    {
        $payload = [
            'eventId' => Uuid::uuid4()->toString(),
            'eventTime' => now()->toISOString(),
            'eventType' => 'employees.delete',
            'metadata' => [
                'api_key' => $this->api_key,
            ],
            'payload' => [
                'employee_id' => 1,
                'employee_name' => 'Test Up Test',
            ],
        ];

        $payloadSignature = RestApiComputeHmacSignatureAction::run([
            'api_key' => $payload['metadata']['api_key'] ?? null,
            'payload' => json_encode($payload),
        ]);

        $response = $this->postJson(route('api.restApi'), $payload, [
            'Authorization' => $payloadSignature,
        ]);
        $responseJson = $response->json() ?? [];

        $this->assertTrue(isset($responseJson['message']) && $responseJson['message'] === 'Deleted.');
    }
}
