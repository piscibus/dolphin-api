<?php


namespace App\Dolphin\Users\Actions\User;

use App\Dolphin\Http\Action;
use App\Dolphin\Passport\Repositories\RefreshTokenRepository;
use App\Dolphin\Passport\Repositories\TokenRepository;
use App\Dolphin\Users\Models\User;
use App\Dolphin\Users\Requests\LogoutRequest;

class Logout implements Action
{
    public const LOGGED_OUT_MESSAGE = 'Logged out!';
    public const LOGGED_OUT_FROM_OTHER_DEVICES_MESSAGE = 'Logged out from other devices!';

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
        return $this->request->isFromOtherDevices() ?
            $this->revokeOtherTokens() :
            $this->revokeThisToken();
    }

    /**
     * Revokes current token
     * @return string[]
     */
    private function revokeThisToken(): array
    {
        $accessTokenId = $this->getAccessTokenId();

        $this->tokens->revokeAccessToken($accessTokenId);
        $this->refreshTokens->revokeRefreshTokensByAccessTokenId($accessTokenId);

        return ['message' => self::LOGGED_OUT_MESSAGE];
    }

    /**
     * Revokes all tokens except this token
     * @return string[]
     */
    private function revokeOtherTokens(): array
    {
        /** @var User $user */
        $user = $this->request->user();
        $accessTokenId = $this->getAccessTokenId();

        $this->tokens->revokeAllExcept($user->getId(), $accessTokenId);
        $this->refreshTokens->revokeAllByAccessTokenExcept($user->getId(), $accessTokenId);

        return ['message' => self::LOGGED_OUT_FROM_OTHER_DEVICES_MESSAGE];
    }

    /**
     * Get current access token id
     * @return string
     */
    private function getAccessTokenId(): string
    {
        /** @var User $user */
        $user = $this->request->user();
        $token = $user->token();
        /** @var string $tokenId */
        $tokenId = $token->id;
        return $tokenId;
    }
}
