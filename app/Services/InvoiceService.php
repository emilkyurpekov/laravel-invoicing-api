<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    private const VAT_RATE = 0.20; // 20% примерен VAT

    
    public function createInvoice(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $itemsData = $data['items'];
            unset($data['items']);

            $totals = $this->calculateTotals($itemsData);

            $invoice = Invoice::create([
                ...$data,
                ...$totals, 
            ]);

            $this->syncItems($invoice, $itemsData);

            return $invoice->load('items');
        });
    }

    
    public function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $itemsData = $data['items'];
            unset($data['items']);

            $totals = $this->calculateTotals($itemsData);

            $invoice->update([
                ...$data,
                ...$totals,
            ]);

            $this->syncItems($invoice, $itemsData);

            return $invoice->fresh()->load('items');
        });
    }

  
    private function calculateTotals(array $items): array
    {
        $subtotal = 0;

        foreach ($items as $item) {
         
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $vat = round($subtotal * self::VAT_RATE, 2);
        $total = $subtotal + $vat;

        return [
            'subtotal' => $subtotal,
            'vat' => $vat,
            'total' => $total,
        ];
    }

    private function syncItems(Invoice $invoice, array $itemsData): void
    {
        $invoice->items()->delete();

        $itemsToCreate = [];
        foreach ($itemsData as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $itemsToCreate[] = [
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $itemTotal,
            ];
        }

        $invoice->items()->createMany($itemsToCreate);
    }
}
