<?php

namespace Database\Factories;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agenda>
 */
class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'starts_at' => $this->faker->dateTimeBetween('now', '+30 days'),
            'ends_at' => null,
            'location' => $this->faker->city().' — Pujon',
            'description' => $this->faker->paragraph(),
        ];
    }
}
