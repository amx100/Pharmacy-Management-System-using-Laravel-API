<?php

namespace Database\Factories;
use App\Models\Drug;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drug>
 */
class DrugFactory extends Factory
{
    protected $model = Drug::class;

    public function definition()
    {
        return [
            'NAME' => $this->faker->word,
            'TYPE' => $this->faker->word,
            'DOSE' => $this->faker->word,
            'SELLING_PRICE' => $this->faker->randomFloat(2, 1, 100),
            'EXPIRATION_DATE' => $this->faker->date,
            'QUANTITY' => $this->faker->numberBetween(1, 100),
          
        ];
    }
}
