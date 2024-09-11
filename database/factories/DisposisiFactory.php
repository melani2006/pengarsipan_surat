<?php

namespace Database\Factories;

use App\Models\Disposisi;
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
            'to' => $this->faker->name(),
            'due_date' => $this->faker->date(),
            'content' => $this->faker->sentence(10),
            'Catatan' => $this->faker->sentence(3),
            'status_surat' => $this->faker->numberBetween(1,3),
            'surat_id' => $this->faker->numberBetween(1, 50),
            'user_id' => 1,
        ];
    }
}
