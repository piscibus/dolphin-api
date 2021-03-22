<?php


namespace App\Dolphin\Users\Actions\Guest;

use App\Dolphin\Http\Action;
use App\Dolphin\Users\Exceptions\InvalidLoginCredentials;
use App\Dolphin\Users\Requests\LoginRequest;
use App\Dolphin\Users\Resources\UserResource;
use App\Dolphin\Users\Services\AccessTokenService;
use Illuminate\Support\Facades\Auth;

class Login implements Action
{
    /**
     * @var LoginRequest
     */
    private $request;

    /**
     * @var AccessTokenService
     */
    private $accessToken;

    /**
     * Login constructor.
     * @param LoginRequest $request
     * @param AccessTokenService $accessToken
     */
    public function __construct(LoginRequest $request, AccessTokenService $accessToken)
    {
        $this->request = $request;
        $this->accessToken = $accessToken;
    }

    /**
     * Executes the requested action
     *
     * @return UserResource
     * @throws InvalidLoginCredentials
     */
    public function execute(): UserResource
    {
        $this->request->setInclude(['token']);

        $valid = Auth::attempt([
            'email' => $this->request->getEmail(),
            'password' => $this->request->getInputPassword(),
        ]);

        if ($valid) {
            $user = $this->request->user();
            return new UserResource($user, $this->accessToken);
        }

        throw new InvalidLoginCredentials();
    }
}
