<?php


namespace App\Dolphin\Passport\Repositories;

class RefreshTokenRepository extends \Laravel\Passport\RefreshTokenRepository
{
    public function revokeAllByAccessTokenExcept(int $userId, string $accessTokenId)
    {
        // TODO implement method revokeAllByAccessTokenExcept
    }
}
