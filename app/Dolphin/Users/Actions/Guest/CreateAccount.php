<?php

namespace App\Dolphin\Users\Actions\Guest;

use App\Dolphin\Http\Action;
use App\Dolphin\Users\Models\User;
use App\Dolphin\Users\Requests\CreateAccountRequest;
use App\Dolphin\Users\Resources\UserResource;
use App\Dolphin\Users\Services\AccessTokenService;

/**
 * Class CreateAccount
 * @package App\Dolphin\Users\Actions\Guest
 */
class CreateAccount implements Action
{
    /**
     * @var CreateAccountRequest
     */
    private $request;

    /**
     * @var User
     */
    private $user;
    /**
     * @var AccessTokenService
     */
    private $acessTokenService;

    /**
     * CreateAccount constructor.
     * @param CreateAccountRequest $request
     * @param User $user
     * @param AccessTokenService $accessTokenService
     */
    public function __construct(CreateAccountRequest $request, User $user, AccessTokenService $accessTokenService)
    {
        $this->request = $request;
        $this->user = $user;
        $this->acessTokenService = $accessTokenService;
    }

    /**
     * Executes the requested action
     *
     * @return UserResource
     */
    public function execute(): UserResource
    {
        $this->request->setInclude(['token']);

        $this->user->setEmail($this->request->getEmail());
        $this->user->setName($this->request->getName());
        $this->user->setPassword(bcrypt($this->request->InputPassword()));

        $this->user->save();

        return new UserResource($this->user, $this->acessTokenService);
    }
}
