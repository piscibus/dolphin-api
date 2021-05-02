<?php


namespace App\Dolphin\Users\Repositories;

use App\Dolphin\Users\Models\Profile;

class ProfileRepository
{
    /**
     * @var Profile
     */
    private Profile $model;

    /**
     * ProfileRepository constructor.
     */
    public function __construct(Profile $model)
    {
        $this->model = $model;
    }

    public function findBy(array $array): ?Profile
    {
        return null;
    }
}
