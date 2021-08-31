<?php

use \App\Http\Controllers\RestApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
], function () {
    Route::post('/', RestApiController::class)
        ->middleware([
            'force.json:400',
            'restApi.authorize',
        ])->name('restApi');
});
