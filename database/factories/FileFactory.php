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
            'path' => '/images/avatar.png',
            'meta_data' => ['width' => 512, 'height' => 512],
            'mime_type' => 'image/png',
            'extension' => 'png',
            'disk' => 'fake_disk'
        ]);
    }
}
