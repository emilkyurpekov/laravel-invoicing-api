<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class InvoiceItemFactory extends Factory
{
   
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 10);
        $unitPrice = $this->faker->randomFloat(2, 20, 500);

        return [
            'description' => $this->faker->sentence(3),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $quantity * $unitPrice, 
        ];
    }
}