<?php


namespace App\Dolphin\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class HasUuid
 * @package App\Dolphin\Traits
 * @mixin Model
 */
trait HasUuid
{
    /**
     * boots the trait
     */
    protected static function bootHasUuid()
    {
        static::creating(function (Model $entity) {
            $entity->{$entity->getKeyName()} = Str::orderedUuid()->toString();
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
