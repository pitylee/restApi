<?php

namespace App\Actions;

use App\Models\ApiKeys;

class RestApiComputeHmacSignatureAction extends BaseAction
{
    /**
     * @return mixed
     */
    public function rules(): array
    {
        return [
            'api_key' => ['required', 'exists:api_keys,api_key'],
            'payload' => ['required']
        ];
    }

    /**
     * @return mixed|string
     */
    public function handle()
    {
        $apiKey = ApiKeys::where('api_key', $this->api_key)->first();

        return 'MAC ' . base64_encode(hash_hmac(
                'sha1',
                $this->payload,
                $apiKey->api_secret,
                true
            ));
    }
}
