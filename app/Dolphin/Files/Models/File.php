<?php

namespace App\Dolphin\Files\Models;

use App\Dolphin\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @method static File create(array $attributes)
 * @property string $id
 * @property string $path
 * @property string $disk
 * @property string $meta_data
 */
class File extends Model
{
    use HasUuid;

    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @param  array  $value
     */
    public function setMetaDataAttribute(array $value): void
    {
        $this->attributes['meta_data'] = json_encode($value);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * @return string
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function getUrl(): string
    {
        $disk = Storage::disk($this->disk);
        return $disk->url($this->getPath());
    }

    /**
     * @return array
     */
    public function getMetaData(): array
    {
        return json_decode($this->meta_data, true);
    }
}
