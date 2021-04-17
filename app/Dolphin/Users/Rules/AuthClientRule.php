<?php


namespace App\Dolphin\Users\Rules;

use App\Dolphin\Passport\Repositories\ClientRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class AuthClientRule
 * @package App\Dolphin\Users\Rules
 */
class AuthClientRule implements Rule
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $secret;

    /**
     * @param  int  $clientId
     * @return static
     */
    public static function id(int $clientId): self
    {
        $obj = new self();
        return $obj->setId($clientId);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     * @throws BindingResolutionException
     */
    public function passes($attribute, $value)
    {
        /** @var ClientRepository $clients */
        $clients = app()->make(ClientRepository::class);
        $client = $clients->find($this->id);

        if ($client->secret !== $this->secret) {
            return false;
        }

        if ($client->revoked) {
            return false;
        }

        if (!$client->password_client) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return "The client credentials are invalid.";
    }

    /**
     * @param  string  $clientSecret
     * @return $this
     */
    public function secret(string $clientSecret): self
    {
        return $this->setSecret($clientSecret);
    }

    /**
     * @param  int  $id
     * @return AuthClientRule
     */
    public function setId(int $id): AuthClientRule
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param  string  $secret
     * @return AuthClientRule
     */
    public function setSecret(string $secret): AuthClientRule
    {
        $this->secret = $secret;
        return $this;
    }
}
