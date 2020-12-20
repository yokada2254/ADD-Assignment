<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        switch(intval(microtime(true) * 10000) % 3 + 1){
            case 1:
                return [
                    'contact_type_id' => 1,
                    'data' => $this->faker->phoneNumber,
                ];
            case 2:
                return [
                    'contact_type_id' => 2,
                    'data' => $this->faker->safeEmail,
                ];
            case 3:
                return [
                    'contact_type_id' => 3,
                    'data' => $this->faker->lexify('?????????'),
                ];
        }
    }
}
