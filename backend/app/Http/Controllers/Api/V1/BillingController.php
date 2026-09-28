<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $clinic_id = $request->user()->clinic_id;

        $invoices = Invoice::where('clinic_id', $clinic_id)->with('patient')->paginate(20);
        $expenses = Expense::where('clinic_id', $clinic_id)->paginate(20);

        return response()->json([
            'data' => [
                'invoices' => $invoices,
                'expenses' => $expenses,
                'summary' => [
                    'revenue' => Invoice::where('clinic_id', $clinic_id)->sum('total_amount'),
                    'expenses' => Expense::where('clinic_id', $clinic_id)->sum('amount'),
                    'outstanding' => Invoice::where('clinic_id', $clinic_id)->where('status', '!=', 'paid')->sum('total_amount'),
                ],
            ],
            'message' => 'Billing dashboard retrieved successfully.',
        ]);
    }

    public function createInvoice(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $amount = (float) ($validated['subtotal'] ?? 0);
        $discount = (float) ($validated['discount_amount'] ?? 0);
        $tax = (float) ($validated['tax_amount'] ?? 0);

        $invoice = Invoice::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'total_amount' => $amount - $discount + $tax,
            'status' => 'draft',
        ]);

        return response()->json([
            'data' => $invoice,
            'message' => 'Invoice created successfully.',
        ], Response::HTTP_CREATED);
    }

    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);

        $payment = Payment::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'status' => 'completed',
            'reference_number' => 'PAY-' . now()->format('YmdHis'),
        ]);

        return response()->json([
            'data' => $payment,
            'message' => 'Payment recorded successfully.',
        ], Response::HTTP_CREATED);
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'vendor' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $expense = Expense::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'status' => 'approved',
        ]);

        return response()->json([
            'data' => $expense,
            'message' => 'Expense recorded successfully.',
        ], Response::HTTP_CREATED);
    }
}
