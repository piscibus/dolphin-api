<?php

namespace App\Http\Controllers\Api;

use App\Dolphin\Users\Actions\Guest\Login;
use App\Dolphin\Users\Exceptions\InvalidLoginCredentials;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class EmailLoginController extends Controller
{
    /**
     * @param Login $action
     * @return JsonResponse
     * @throws InvalidLoginCredentials
     */
    public function store(Login $action)
    {
        return $action->execute()->response();
    }
}
