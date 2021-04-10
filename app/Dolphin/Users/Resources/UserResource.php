<?php


namespace App\Dolphin\Users\Resources;

use App\Dolphin\Http\Resource;
use App\Dolphin\Users\Models\User;
use App\Dolphin\Users\Services\AccessTokenService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class UserResource
 * @package App\Dolphin\Users\Resources
 * @mixin User
 */
class UserResource extends Resource
{
    /**
     * @var AccessTokenService
     */
    private $accessTokenService;

    /**
     * UserResource constructor.
     * @param $resource
     * @param AccessTokenService|null $accessTokenService
     */
    public function __construct($resource, ?AccessTokenService $accessTokenService = null)
    {
        parent::__construct($resource);
        $this->accessTokenService = $accessTokenService;
    }

    /**
     * @var string[]
     */
    protected $includes = ['token'];

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
            'name' => $this->getName(),
            'email' => $this->getEmail(),
        ];
    }

    /**
     * @param User $user
     * @return TokenResource
     * @throws BindingResolutionException
     */
    public function includeToken(User $user): TokenResource
    {
        $token = $this->accessTokenService->issueToken();
        return new TokenResource($token);
    }
}
