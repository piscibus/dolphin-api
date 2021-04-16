<?php


namespace App\Dolphin\Users\Requests;

use App\Dolphin\Http\Request;

/**
 * Class LogoutRequest
 * @package App\Dolphin\Users\Requests
 */
class LogoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !is_null($this->user());
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
