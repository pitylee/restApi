<?php

namespace App\Http\Controllers;

use App\Factories\RestApiEventManager;
use Illuminate\Http\Request;

class RestApiController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return resolve(RestApiEventManager::class)
            ->driver(str_replace('.', '_', $request->get('eventType')))
            ->handle($request->all());
    }
}
