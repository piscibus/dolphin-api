<?php


namespace App\Dolphin\Users\Requests;

use App\Dolphin\Http\Request;
use App\Dolphin\Users\Rules\PasswordRule;

/**
 * Class LoginRequest
 * @package App\Dolphin\Users\Requests
 */
class LoginRequest extends Request
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
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', new PasswordRule()],
            'client_id' => ['required', 'exists:oauth_clients,id'],
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
    public function getInputPassword(): string
    {
        return $this->get('password');
    }
}
