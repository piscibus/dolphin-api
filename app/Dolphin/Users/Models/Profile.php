<?php


namespace App\Dolphin\Users\Models;

use App\Dolphin\Files\Models\File;
use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property File $avatar
 * @property int $id
 * @property int $user_id
 * @property string $name
 */
class Profile extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'profiles';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return ProfileFactory
     */
    protected static function newFactory(): ProfileFactory
    {
        return ProfileFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function avatar(): BelongsTo
    {
        $columns = ['id', 'meta_data'];
        return $this->belongsTo(File::class)->select($columns);
    }

    /**
     * @return File
     */
    public function getAvatar(): File
    {
        return $this->avatar;
    }

    /**
     * @return array
     */
    public function getPublicAvatar(): array
    {
        $id = $this->avatar->getId();
        return array_merge(compact('id'), $this->avatar->getMetaData());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
