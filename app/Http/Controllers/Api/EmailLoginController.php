<?php

namespace App\Http\Controllers\Api;

use App\Dolphin\Users\Actions\Guest\Login;
use App\Dolphin\Users\Actions\User\Logout;
use App\Dolphin\Users\Exceptions\InvalidLoginCredentials;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class EmailLoginController
 * @package App\Http\Controllers\Api
 */
class EmailLoginController extends Controller
{
    /**
     * @param  Login  $action
     * @return JsonResponse
     * @throws InvalidLoginCredentials
     */
    public function store(Login $action)
    {
        return $action->execute()->response();
    }

    /**
     * @param  Logout  $action
     * @return JsonResponse
     */
    public function destroy(Logout $action)
    {
        return response()->json($action->execute());
    }
}
