<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'date' => $this->date,
            'due_date' => $this->due_date,
            'subtotal' => (float) $this->subtotal,
            'vat' => (float) $this->vat,
            'total' => (float) $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            'items' => InvoiceItemResource::collection($this->whenLoaded('items')),
        ];
    }
}