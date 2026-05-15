<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class StudentInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('student_id', Auth::id())
            ->latest()
            ->get();

        return view('murid.invoices.index', compact('invoices'));
    }

    public function pay(Invoice $invoice)
    {
        if ($invoice->student_id !== Auth::id()) abort(403);
        if ($invoice->status === 'paid') {
            Alert::info('Info', 'Tagihan ini sudah dibayar.');
            return back();
        }

        // Pseudo-payment / Midtrans Integration
        if (!$invoice->snap_token) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-DUMMY');
            \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
            \Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS', true);

            $params = array(
                'transaction_details' => array(
                    'order_id' => 'INV-' . $invoice->id . '-' . time(),
                    'gross_amount' => $invoice->amount,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ),
            );

            try {
                // If dummy key is used, Midtrans will throw 401. Catch it to provide pseudo token.
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $invoice->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Pseudo token fallback for testing without real keys
                $pseudoToken = 'pseudo_' . Str::random(32);
                $invoice->update(['snap_token' => $pseudoToken]);
            }
        }

        return view('murid.invoices.pay', compact('invoice'));
    }
}
