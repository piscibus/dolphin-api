<?php

namespace App\Dolphin\Files\Requests;

use App\Dolphin\Files\Actions\UploadAvatarAction;
use App\Dolphin\Http\Request;
use Illuminate\Http\UploadedFile;

class StoreFileRequest extends Request
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return !is_null($this->user());
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'action' => ['required', 'in:avatar.store'],
            'file' => ['required', 'image']
        ];
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return UploadAvatarAction::class;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        /** @var UploadedFile $file */
        $file = $this->file('file');

        return $file;
    }
}
