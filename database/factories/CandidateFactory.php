<?php

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'candidate_number' => $this->faker->unique()->numberBetween(1, 100),
            'name' => $this->faker->name,
            'position' => $this->faker->randomElement(['Ketua OSIS', 'Ketua MPK']),
            'visi' => $this->faker->sentence,
            'misi' => $this->faker->paragraph,
            'photo_path' => 'photos/default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
