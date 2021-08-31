<?php

namespace App\Http\Middleware;

use App\Actions\RestApiComputeHmacSignatureAction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class RestApiAuthorizedRequest
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('Request from api: ' . $request);

        if (!$request->hasHeader('Authorization')) {
            throw new UnauthorizedException('Rest Api event payload is malformed.');
        }

        if ($request->header('Content-Type') !== 'application/json') {
            throw new UnauthorizedException('Rest Api Content-Type must be application/json.');
        }

        $hashSignatureDigest = RestApiComputeHmacSignatureAction::run([
            'data' => $request->json()->all() ?? [],
            'api_key' => $request['metadata']['api_key'] ?? null,
            'payload' => $request->getContent(),
        ]);

        Log::info('Waiting for MAC: ' . $hashSignatureDigest . ' on latest request.');

        if ($request->header('Authorization') !== $hashSignatureDigest) {
            throw new UnauthorizedException('Rest Api event payload is malformed.');
        }

        return $next($request);
    }
}
