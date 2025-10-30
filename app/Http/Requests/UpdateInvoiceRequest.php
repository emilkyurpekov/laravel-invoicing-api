<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        $invoiceId = $this->route('invoice')->id;

        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('invoices', 'number')->ignore($invoiceId),
            ],
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'status' => ['required', Rule::in(['unpaid', 'paid', 'draft'])],
            
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:500',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }
}
