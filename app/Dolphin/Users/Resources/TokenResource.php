<?php


namespace App\Dolphin\Users\Resources;

use App\Dolphin\Http\Resource;
use App\Dolphin\Passport\AccessTokenResult;

/**
 * Class TokenResource
 * @package App\Dolphin\Users\Resources
 * @mixin AccessTokenResult
 */
class TokenResource extends Resource
{
    /**
     * Handles the resource transformation into an array
     *
     * @param $request
     * @return array
     */
    protected function handle($request): array
    {
        return [
            'token_type' => $this->getTokenType(),
            'access_token' => $this->getAccessToken(),
            'refresh_token' => $this->getRefreshToken(),
            'expires_in' => $this->getExpiresIn(),
        ];
    }
}
