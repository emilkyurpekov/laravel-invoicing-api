<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
   
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-6 months');
        
        return [
            'number' => 'INV-' . $this->faker->unique()->numberBetween(1000, 9999),
            'customer_name' => $this->faker->company(),
            'customer_email' => $this->faker->safeEmail(),
            'date' => $date,
            'due_date' => (clone $date)->modify('+30 days'),
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'draft']),
            
            'subtotal' => 0,
            'vat' => 0,
            'total' => 0,
        ];
    }

  
    public function configure(): static
    {
        return $this->afterCreating(function (Invoice $invoice) {
            $items = InvoiceItem::factory($this->faker->numberBetween(3, 5))->make();
            
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item->total;
                $invoice->items()->save($item);
            }

            $vat = round($subtotal * 0.20, 2);
            $total = $subtotal + $vat;
            
            $invoice->subtotal = $subtotal;
            $invoice->vat = $vat;
            $invoice->total = $total;
            $invoice->saveQuietly();
        });
    }
}