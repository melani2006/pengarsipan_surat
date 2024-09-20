<?php

namespace Database\Factories;

use App\Enums\LetterType;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Surat>
 */
class SuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_surat' => $this->faker->ean13(),
            'nomor_agenda' => $this->faker->randomNumber(5),
            'pengirim' => $this->faker->name('male'),
            'penerima' => $this->faker->name('female'),
            'tanggal_surat' => $this->faker->date(),
            'tanggal_diterima'=> $this->faker->date(),
            'deskripsi' => $this->faker->sentence(7),
            'catatan' => $this->faker->sentence(3),
            'type' => $this->faker->randomElement([LetterType::INCOMING->type(), LetterType::OUTGOING->type()]),
            'kategori_code' => 'ADM',
            'user_id' => 1,
        ];
    }
}