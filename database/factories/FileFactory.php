<?php

namespace Database\Factories;

use App\Dolphin\Files\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->uuid
        ];
    }

    /**
     * Creates an avatar instance
     * @return FileFactory
     */
    public function avatar(): FileFactory
    {
        return $this->state(fn () => [
            'path' => File::DEV_AVATAR_ASSET,
            'meta_data' => ['width' => File::DEV_AVATAR_DIMENSION, 'height' => File::DEV_AVATAR_DIMENSION],
            'mime_type' => File::DEV_AVATAR_MIME_TYPE,
            'extension' => File::DEV_AVATAR_EXTENSION,
            'disk' => File::DEV_DISK,
        ]);
    }
}
