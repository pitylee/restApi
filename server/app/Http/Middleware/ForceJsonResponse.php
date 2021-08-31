<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param int|null $errorStatusCode
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $errorStatusCode = null)
    {
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);
        if (!$response->isSuccessful()) {
            $response->setStatusCode($errorStatusCode);
        }

        return $response;
    }
}
