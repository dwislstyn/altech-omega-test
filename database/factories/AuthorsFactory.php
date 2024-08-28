<?php

namespace Database\Factories;

use App\Models\Authors;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorsFactory extends Factory
{
    protected $model = Authors::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'bio' => $this->faker->text,
            'birth_date' => $this->faker->date,
        ];
    }
}
