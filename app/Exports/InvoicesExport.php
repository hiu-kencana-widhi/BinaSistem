<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoicesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::with('student')->get();
    }

    public function headings(): array
    {
        return [
            'ID Tagihan',
            'Nama Siswa',
            'Email Siswa',
            'Bulan',
            'Tahun',
            'Nominal (Rp)',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->student->name ?? '-',
            $invoice->student->email ?? '-',
            $invoice->month,
            $invoice->year,
            $invoice->amount,
            strtoupper($invoice->status),
            $invoice->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
