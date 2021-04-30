<?php


namespace App\Dolphin\Users\Resources;

use App\Dolphin\Http\Resource;
use App\Dolphin\Users\Models\Profile;

/**
 * Class ProfileResource
 * @package App\Dolphin\Users\Resources
 * @mixin Profile
 */
class ProfileResource extends Resource
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
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'name' => $this->getName(),
            'avatar' => $this->getPublicAvatar(),
        ];
    }
}
