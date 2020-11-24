<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand' => $this->faker->name,
            'make' => $this->faker->name,
            'license_plate' => '12ABCD',
            'date_acquired'=>now(),
            'value' => 0,
            'company_id' => 1,
        ];
    }
}
