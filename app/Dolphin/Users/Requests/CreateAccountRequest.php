<?php


namespace App\Dolphin\Users\Requests;

use App\Dolphin\Http\Request;
use App\Dolphin\Users\Rules\AuthClientRule;
use App\Dolphin\Users\Rules\PasswordRule;
use Illuminate\Support\Str;

/**
 * Class CreateAccountRequest
 * @package App\Dolphin\Users\Requests
 */
class CreateAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return is_null($this->user());
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        $clientSecret = $this->getClientSecret();
        $clientId = $this->getClientId();

        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', new PasswordRule()],
            'client_id' => ['required', AuthClientRule::id($clientId)->secret($clientSecret)],
            'client_secret' => ['required']
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->get('email');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name') ?? $this->generateNameFromEmail();
    }

    /**
     * @return string
     */
    public function InputPassword(): string
    {
        return $this->get('password');
    }

    /**
     * @return string
     */
    private function getClientSecret(): string
    {
        return $this->get('client_secret');
    }

    /**
     * @return int
     */
    private function getClientId(): int
    {
        return $this->get('client_id');
    }

    /**
     * @return string
     */
    private function generateNameFromEmail(): string
    {
        return (string) Str::of($this->getEmail())->before('@');
    }
}
