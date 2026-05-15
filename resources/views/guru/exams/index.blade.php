@extends('layouts.app')

@section('title', 'Manajemen Evaluasi (CBT)')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Pusat Evaluasi Digital</h1>
        <p class="harvard-academic-subtitle">Manajemen ujian berbasis komputer (CBT) dan bank soal.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.exams.create') }}" class="harvard-btn-primary">
            Konfigurasi Ujian Baru
        </a>
    </div>
</div>

<div class="harvard-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="harvard-data-table">
            <thead>
                <tr>
                    <th>Judul Ujian</th>
                    <th>Disiplin Ilmu</th>
                    <th>Durasi</th>
                    <th>Jadwal Pelaksanaan</th>
                    <th>Status Soal</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                <tr>
                    <td class="font-serif font-bold text-[#A51C30]">{{ $exam->title }}</td>
                    <td>{{ $exam->subject->name }}</td>
                    <td class="font-sans text-xs font-bold text-slate-600">
                        {{ $exam->duration_minutes }} <span class="text-[9px] uppercase tracking-widest text-slate-400 ml-1">Menit</span>
                    </td>
                    <td class="text-slate-500 text-[10px] font-sans uppercase tracking-tight">
                        @if($exam->start_time)
                            {{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y, H:i') }}
                        @else
                            <span class="italic text-slate-300">Open Schedule</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center">
                            <span class="text-sm font-bold text-[#1E1E1E]">{{ $exam->questions->count() }}</span>
                            <span class="text-[9px] text-slate-400 ml-1 uppercase tracking-widest">Butir Soal</span>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('guru.exams.show', $exam) }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-[#A51C30] transition-colors underline underline-offset-4">Detail</a>
                            <a href="{{ route('guru.questions.create', ['exam_id' => $exam->id]) }}" class="text-[10px] font-bold uppercase tracking-widest text-[#BD9B60] hover:text-[#A51C30] transition-colors underline underline-offset-4">+ Soal</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-16 text-slate-400 italic font-serif text-lg">Belum ada konfigurasi ujian digital yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($exams->hasPages())
    <div class="p-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
        {{ $exams->links() }}
    </div>
    @endif
</div>
@endsection
