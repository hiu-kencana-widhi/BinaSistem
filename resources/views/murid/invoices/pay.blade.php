@extends('layouts.app')

@section('title', 'Pembayaran Tagihan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Checkout Pembayaran</h1>
            <p class="text-sm text-slate-500 mt-1">Selesaikan pembayaran tagihan SPP Anda.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('murid.invoices.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-sm text-slate-500">Tagihan Untuk</p>
                    <p class="text-lg font-bold text-slate-800">{{ \Carbon\Carbon::createFromDate($invoice->year, $invoice->month, 1)->translatedFormat('F Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">ID Invoice</p>
                    <p class="text-sm font-mono font-bold text-slate-800">INV-{{ $invoice->id }}</p>
                </div>
            </div>
            
            <div class="bg-slate-50 rounded-lg p-4 flex justify-between items-center border border-slate-100">
                <span class="font-medium text-slate-700">Total Pembayaran</span>
                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Metode Pembayaran</h3>
            <p class="text-sm text-slate-600 mb-6">Silakan klik tombol di bawah ini untuk memunculkan panel pembayaran Midtrans.</p>
            
            @if(str_starts_with($invoice->snap_token, 'pseudo_'))
                <!-- PSEUDO PAYMENT (Fallback when Midtrans Keys are not set) -->
                <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-lg text-sm mb-6">
                    <strong>Mode Simulasi:</strong> Kunci API Midtrans tidak terkonfigurasi. Tombol ini akan menyimulasikan keberhasilan pembayaran (Pseudo-Callback).
                </div>
                <button id="pay-button" class="w-full justify-center flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Simulasikan Pembayaran
                </button>

                <script>
                    document.getElementById('pay-button').onclick = function(){
                        fetch('{{ route("api.pseudo.callback") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ invoice_id: {{ $invoice->id }} })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === 'success') {
                                alert('Pembayaran berhasil disimulasikan!');
                                window.location.href = "{{ route('murid.invoices.index') }}";
                            }
                        });
                    };
                </script>

            @else
                <!-- REAL MIDTRANS PAYMENT -->
                <button id="pay-button" class="w-full justify-center flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Bayar dengan Midtrans
                </button>

                <!-- Midtrans Snap JS -->
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
                <script type="text/javascript">
                    document.getElementById('pay-button').onclick = function(){
                        snap.pay('{{ $invoice->snap_token }}', {
                            onSuccess: function(result){
                                alert("Pembayaran berhasil!");
                                window.location.href = "{{ route('murid.invoices.index') }}";
                            },
                            onPending: function(result){
                                alert("Menunggu pembayaran Anda!");
                                window.location.href = "{{ route('murid.invoices.index') }}";
                            },
                            onError: function(result){
                                alert("Pembayaran gagal!");
                            },
                            onClose: function(){
                                console.log('customer closed the popup without finishing the payment');
                            }
                        });
                    };
                </script>
            @endif
        </div>
    </div>
</div>
@endsection
