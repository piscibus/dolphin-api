<?php

namespace App\Http\Controllers\Api;

use App\Dolphin\Users\Actions\User\ShowProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MyProfileController extends Controller
{
    private ShowProfile $action;

    /**
     * MyProfileController constructor.
     * @param  ShowProfile  $action
     */
    public function __construct(ShowProfile $action)
    {
        $this->action = $action;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->action->execute()->response();
    }
}
