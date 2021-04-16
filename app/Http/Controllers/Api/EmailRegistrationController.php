<?php

namespace App\Http\Controllers\Api;

use App\Dolphin\Users\Actions\Guest\CreateAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class EmailRegistrationController
 * @package App\Http\Controllers\Api
 */
class EmailRegistrationController extends Controller
{
    /**
     * @param CreateAccount $action
     * @return JsonResponse
     */
    public function store(CreateAccount $action): JsonResponse
    {
        $response = $action->execute()->response();
        $response->setStatusCode(201);
        return $response;
    }
}
