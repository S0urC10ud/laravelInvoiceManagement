<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Name" => $this->faker->name,
            "PriceNet" => rand(0,100),
            "PriceGross" => rand(0,100),
            "Vat" => rand(0,100),
            "UserClearing" => $this->faker->name,
            "ClearingDate" => $this->faker->dateTime
        ];
    }
}
