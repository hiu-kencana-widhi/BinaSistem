<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function midtransCallback(Request $request)
    {
        // Accept payload
        $payload = $request->all();
        
        Log::info('Midtrans Webhook:', $payload);

        // Normally you verify signature key here:
        // $serverKey = env('MIDTRANS_SERVER_KEY');
        // $signatureKey = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);
        // if ($signatureKey != $payload['signature_key']) return response()->json(['message' => 'Invalid Signature'], 403);

        $orderIdParts = explode('-', $payload['order_id'] ?? '');
        // Order ID format we used: INV-{id}-{timestamp}
        if (count($orderIdParts) >= 2 && $orderIdParts[0] === 'INV') {
            $invoiceId = $orderIdParts[1];
            $transactionStatus = $payload['transaction_status'] ?? 'pending';

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                DB::transaction(function () use ($invoiceId) {
                    $invoice = Invoice::lockForUpdate()->find($invoiceId);
                    if ($invoice && $invoice->status === 'unpaid') {
                        $invoice->update(['status' => 'paid']);
                        Log::info("Invoice {$invoiceId} marked as PAID.");
                    }
                });
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function pseudoCallback(Request $request)
    {
        // This is a pseudo-callback to simulate Midtrans JS onSuccess event
        $invoiceId = $request->input('invoice_id');
        
        if ($invoiceId) {
            DB::transaction(function () use ($invoiceId) {
                $invoice = Invoice::lockForUpdate()->find($invoiceId);
                if ($invoice && $invoice->status === 'unpaid') {
                    $invoice->update(['status' => 'paid']);
                }
            });
            return response()->json(['status' => 'success']);
        }
        
        return response()->json(['status' => 'error'], 400);
    }
}
