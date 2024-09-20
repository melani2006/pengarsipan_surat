<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposisi>
 */
class DisposisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'penerima' => $this->faker->name(),
            'batas_waktu' => $this->faker->date(),
            'content' => $this->faker->sentence(10),
            'catatan' => $this->faker->sentence(3),
            'status_surat' => $this->faker->numberBetween(1,3),
            'surat_id' => $this->faker->numberBetween(1, 50),
            'user_id' => 1,
        ];
    }
}