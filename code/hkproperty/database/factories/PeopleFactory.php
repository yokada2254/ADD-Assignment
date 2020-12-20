<?php

namespace Database\Factories;

use App\Models\People;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = People::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'hkid' => $this->faker->regexify('[A-Z][0-9]{7}\([0-9]{1}\)'),
            'created_by' => User::inRandomOrder()->first()->id,
            'updated_by' => User::inRandomOrder()->first()->id
        ];
    }
}
