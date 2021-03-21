<?php


namespace App\Dolphin\Users\Services;

use App\Dolphin\Passport\AccessTokenResult;
use App\Dolphin\Passport\Repositories\ClientRepository;
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
     * @var ClientRepository
     */
    private $clients;

    /**
     * AccessTokenService constructor.
     * @param Request $request
     * @param ClientRepository $clients
     */
    public function __construct(Request $request, ClientRepository $clients)
    {
        $this->request = $request;
        $this->clients = $clients;
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
        $client = $this->clients->findPasswordClient();
        $this->request->merge([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $this->request->get('email'),
            'scope' => '',
        ]);
    }
}
