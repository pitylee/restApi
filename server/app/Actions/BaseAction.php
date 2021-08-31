<?php

namespace App\Actions;

use App\Exceptions\ActionValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

abstract class BaseAction
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param array $data
     * @return mixed
     */
    public static function run(array $data = [])
    {
        $instance = app(static::class);

        if (!empty($data)) {
            $instance = $instance->setData($data);
        }

        return $instance->execute();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function __get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fill(array $data)
    {
        return $this->setData($data);
    }

    /**
     * @return mixed
     * @throws ActionValidationException
     */
    protected function execute()
    {
        if (!$this->authorize()) {
            throw new UnauthorizedException('Unauthorized to execute ' . static::class);
        }

        $validator = Validator::make($this->data, $this->rules());

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $this->onActionValidationException($errors);
            throw ActionValidationException::withMessages($errors, static::class);
        }

        return $this->handle();
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @param array $errors
     */
    protected function onActionValidationException(array $errors): void
    {
        return;
    }

    /**
     * @return mixed
     */
    abstract public function handle();
}
