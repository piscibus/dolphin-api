<?php


namespace App\Dolphin\Users\Actions\User;

use App\Dolphin\Http\Action;
use App\Dolphin\Users\Models\User;
use App\Dolphin\Users\Requests\LogoutRequest;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class Logout implements Action
{
    public const LOGGED_OUT_MESSAGE = 'Logged out!';

    /**
     * @var LogoutRequest
     */
    private $request;
    /**
     * @var TokenRepository
     */
    private $tokens;
    /**
     * @var RefreshTokenRepository
     */
    private $refreshTokens;

    /**
     * Logout constructor.
     * @param  LogoutRequest  $request
     * @param  TokenRepository  $tokens
     * @param  RefreshTokenRepository  $refreshTokens
     */
    public function __construct(LogoutRequest $request, TokenRepository $tokens, RefreshTokenRepository $refreshTokens)
    {
        $this->request = $request;
        $this->tokens = $tokens;
        $this->refreshTokens = $refreshTokens;
    }

    /**
     * Executes the requested action
     *
     * @return mixed
     */
    public function execute()
    {
        /** @var User $user */
        $user = $this->request->user();
        $token = $user->token();
        $accessTokenId = $token->id;

        $this->tokens->revokeAccessToken($accessTokenId);
        $this->refreshTokens->revokeRefreshTokensByAccessTokenId($accessTokenId);

        return ['message' => self::LOGGED_OUT_MESSAGE];
    }
}
