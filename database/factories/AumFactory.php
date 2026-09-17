<?php

namespace Database\Factories;

use App\Models\Aum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Aum>
 */
class AumFactory extends Factory
{
    protected $model = Aum::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(Aum::TYPES),
            'name' => $this->faker->company().' Muhammadiyah',
            'address' => $this->faker->address().', Pujon, Malang',
            'phone' => $this->faker->phoneNumber(),
            'description' => $this->faker->paragraph(),
            'maps_url' => 'https://www.google.com/maps?q=Pujon,+Kabupaten+Malang&output=embed',
            'photo' => null,
        ];
    }
}
