<?php


namespace App\Dolphin\Users\Services;

use App\Dolphin\Passport\AccessTokenResult;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenService
{
    /**
     * @var Request
     */
    private $request;

    /**
     * AccessTokenService constructor.
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->prepareRequest();
    }

    /**
     * @return AccessTokenResult
     * @throws BindingResolutionException
     */
    public function issueToken(): AccessTokenResult
    {
        /** @var AccessTokenController $controller */
        $controller = app()->make(AccessTokenController::class);
        /** @var ServerRequestInterface $request */
        $request = app()->make(ServerRequestInterface::class);
        $response = $controller->issueToken($request);
        $content = json_decode($response->getContent(), true);
        return AccessTokenResult::fromArray($content);
    }

    /**
     * Add required params the post body
     */
    protected function prepareRequest(): void
    {
        $this->request->merge([
            'grant_type' => 'password',
            'username' => $this->request->get('email'),
            'scope' => '',
        ]);
    }
}
