<?php

namespace Database\Factories;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuratFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Surat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'reference_number' => $this->faker->unique()->numerify('REF-#####'),
            'agenda_number' => $this->faker->unique()->numerify('AGENDA-#####'),
            'from' => $this->faker->company(),
            'penerima' => $this->faker->company(),
            'Tanggal_Surat' => $this->faker->date(),
            'Tanggal_Diterima' => $this->faker->date(),
            'deskripsi' => $this->faker->sentence(),
            'Catatan' => $this->faker->optional()->sentence(),
            'type' => $this->faker->randomElement(['INCOMING', 'OUTGOING']),
            'kategoris_code' => $this->faker->randomElement(['CODE1', 'CODE2', 'CODE3']),
            'user_id' => \App\Models\User::factory(), // Asumsi bahwa user factory sudah ada
        ];
    }
}
