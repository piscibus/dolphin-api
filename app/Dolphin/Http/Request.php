<?php


namespace App\Dolphin\Http;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 * @package App\Dolphin\Http
 */
abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize(): bool;

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    abstract public function rules(): array;
}
