@extends('layouts.app')

@section('title', 'Konfigurasi Ujian Baru')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Registrasi Evaluasi</h1>
        <p class="harvard-academic-subtitle">Konfigurasi parameter ujian berbasis komputer (CBT).</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.exams.index') }}" class="harvard-btn-outline">
            Kembali ke Daftar
        </a>
    </div>
</div>

<div class="max-w-3xl">
    <div class="harvard-card p-8">
        <form action="{{ route('guru.exams.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="harvard-stat-label block mb-2">Judul Ujian</label>
                <input type="text" name="title" required class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 font-serif text-lg focus:outline-none focus:border-[#A51C30] transition-colors" placeholder="Contoh: Ujian Tengah Semester Ganjil 2024">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="harvard-stat-label block mb-2">Disiplin Ilmu (Mapel)</label>
                    <select name="subject_id" required class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors appearance-none">
                        <option value="">Pilih Mapel</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="harvard-stat-label block mb-2">Durasi Pengerjaan</label>
                    <div class="relative">
                        <input type="number" name="duration_minutes" required min="1" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors" placeholder="90">
                        <span class="absolute right-4 top-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menit</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="harvard-stat-label block mb-2">Jadwal Mulai</label>
                    <input type="datetime-local" name="start_time" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors">
                </div>
                <div>
                    <label class="harvard-stat-label block mb-2">Jadwal Selesai</label>
                    <input type="datetime-local" name="end_time" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors">
                </div>
            </div>

            <div class="pt-6 border-t border-[#E2E2E0] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest leading-relaxed max-w-xs">Setelah menekan tombol simpan, Anda akan diarahkan ke halaman pembuatan butir soal.</p>
                <button type="submit" class="harvard-btn-primary px-12">
                    Lanjut ke Bank Soal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
