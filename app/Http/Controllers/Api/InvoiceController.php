<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * Inject the InvoiceService.
     */
    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    /**
     * Display a paginated list of invoices with filtering.
     */
    public function index(Request $request)
    {
        $query = Invoice::query();

        // Search by customer_name (case-insensitive, partial match)
        if ($request->has('search')) {
            $query->where('customer_name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $invoices = $query->latest()->paginate(15);

        return InvoiceResource::collection($invoices);
    }

    /**
     * Store a newly created invoice.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = $this->invoiceService->createInvoice($request->validated());
        
        return (new InvoiceResource($invoice))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED); // 201
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        // Route-model binding automatically handles 404
        return new InvoiceResource($invoice->load('items'));
    }

    /**
     * Update the specified invoice.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $updatedInvoice = $this->invoiceService->updateInvoice($invoice, $request->validated());
        
        return new InvoiceResource($updatedInvoice);
    }

    /**
     * Remove the specified invoice (soft delete).
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        
        return response()->noContent(); // 204
    }
}
