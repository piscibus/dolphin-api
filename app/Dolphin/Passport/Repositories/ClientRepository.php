<?php


namespace App\Dolphin\Passport\Repositories;

use Illuminate\Database\Query\Builder;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository as BaseClientRepository;
use Laravel\Passport\Passport;

/**
 * Class ClientRepository
 * @package App\Dolphin\Passport\Repositories
 */
class ClientRepository extends BaseClientRepository
{
    /**
     * @return Client
     */
    public function findPasswordClient(): Client
    {
        /** @var Builder $client */
        $client = Passport::client();
        $attributes = [
            'password_client' => true,
        ];
        /** @var Client $result */
        $result = $client->where($attributes)->first();
        return $result;
    }
}
