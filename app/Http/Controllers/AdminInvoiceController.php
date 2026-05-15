<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('student')->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'laporan_tagihan_spp.xlsx');
    }
}
