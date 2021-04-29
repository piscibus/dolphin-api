<?php

namespace App\Dolphin\Files\Models;

use App\Dolphin\Traits\HasUuid;
use Database\Factories\FileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    public const DEV_AVATAR_ASSET = '/images/avatar.png';
    public const DEV_AVATAR_DIMENSION = 500;
    public const DEV_AVATAR_MIME_TYPE = 'image/png';
    public const DEV_AVATAR_EXTENSION = 'png';
    public const DEV_DISK = 'local';

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
        if ($this->shouldGetUrl()) {
            $disk = Storage::disk($this->disk);
            return $disk->url($this->getPath());
        }
        return asset(self::DEV_AVATAR_ASSET);
    }

    /**
     * @return array
     */
    public function getMetaData(): array
    {
        return json_decode($this->meta_data, true);
    }

    /**
     * @return bool
     */
    public function shouldGetUrl(): bool
    {
        $environment = config('app.env');
        return $environment === 'production' || $environment === 'staging';
    }

    /**
     * @param  string  $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return FileFactory
     */
    protected static function newFactory(): FileFactory
    {
        return FileFactory::new();
    }
}
