<?php


namespace App\Dolphin\Passport;

/**
 * Class AccessTokenResult
 * @package App\Dolphin\Passport
 */
class AccessTokenResult
{
    /**
     * @var string
     */
    protected $tokenType;

    /**
     * @var int
     */
    protected $expiresIn;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $refreshToken;

    /**
     * AccessTokenResult constructor.
     * @param string $tokenType
     * @param int $expiresIn
     * @param string $accessToken
     * @param string $refreshToken
     */
    public function __construct(string $tokenType, int $expiresIn, string $accessToken, string $refreshToken)
    {
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['token_type'],
            $data['expires_in'],
            $data['access_token'],
            $data['refresh_token']
        );
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
