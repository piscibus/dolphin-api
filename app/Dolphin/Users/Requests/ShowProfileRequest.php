<?php

namespace App\Dolphin\Users\Requests;

use App\Dolphin\Http\Request;

class ShowProfileRequest extends Request
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [];
    }
}
