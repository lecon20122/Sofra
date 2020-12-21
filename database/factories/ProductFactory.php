<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' =>$this->faker->numberBetween($min = 10, $max = 150),
            'offer' =>$this->faker->randomDigit,
            'restaurant_id' => 8 ,
            'ready_in' => 60,
            'short_describtion' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
