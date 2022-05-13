<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tipodocumento;

class CustomerFactory extends Factory
{

    public function definition()
    {
        return [
            'numdoc' => $this->faker->unique()->randomNumber(),
            'nomrazonsocial' => $this->faker->unique()->name(),
            'address' => $this->faker->name(),
            'phone' => $this->faker->randomNumber(),
            'movil' => $this->faker->randomNumber(),
            'email' => $this->faker->unique()->safeEmail,
            'contact' => $this->faker->name,
            'state' => true,
            'tipodocumento_id' =>Tipodocumento::all()->random()->id,

        ];
    }
}
