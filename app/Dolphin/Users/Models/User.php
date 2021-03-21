<?php


namespace App\Dolphin\Users\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Class User
 * @package App\Dolphin\Users\Models
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $name
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return PersonalAccessTokenResult
     */
    public function issueAccessToken(): PersonalAccessTokenResult
    {
        $name = sprintf('%s access token', config('app.name'));
        return $this->createToken($name);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
