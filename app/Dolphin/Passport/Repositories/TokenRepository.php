<?php


namespace App\Dolphin\Passport\Repositories;

use Laravel\Passport\Passport;

class TokenRepository extends \Laravel\Passport\TokenRepository
{
    /**
     * Revoke all access token fot the specified user except the submitted access token
     * @param  int  $userId
     * @param  string  $accessTokenId
     * @return mixed
     */
    public function revokeAllExcept(int $userId, string $accessTokenId)
    {
        return Passport::token()
            ->where('user_id', $userId)
            ->where('id', '!=', $accessTokenId)
            ->update(['revoked' => true]);
    }
}
