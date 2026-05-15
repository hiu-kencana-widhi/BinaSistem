@extends('layouts.app')

@section('title', 'Detail Ujian Digital')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Manifest Evaluasi</h1>
        <p class="harvard-academic-subtitle">Detail konfigurasi dan butir soal: {{ $exam->title }}</p>
    </div>
    <div class="mt-4 md:mt-0 flex gap-4">
        <a href="{{ route('guru.questions.create', ['exam_id' => $exam->id]) }}" class="harvard-btn-primary !text-[10px]">
            + Tambah Soal
        </a>
        <a href="{{ route('guru.exams.index') }}" class="harvard-btn-outline !text-[10px]">
            Daftar Ujian
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Sidebar Info -->
    <div class="space-y-6">
        <div class="harvard-card p-6">
            <h3 class="harvard-stat-label mb-4 border-b border-[#E2E2E0] pb-2">Informasi Umum</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-slate-400">Mata Pelajaran</p>
                    <p class="font-serif font-bold text-[#1E1E1E]">{{ $exam->subject->name }}</p>
                </div>
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-slate-400">Durasi</p>
                    <p class="font-sans font-bold text-[#A51C30]">{{ $exam->duration_minutes }} Menit</p>
                </div>
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-slate-400">Total Soal</p>
                    <p class="font-sans font-bold text-[#1E1E1E]">{{ $exam->questions->count() }} Butir</p>
                </div>
            </div>
        </div>

        <div class="harvard-card p-6">
            <h3 class="harvard-stat-label mb-4 border-b border-[#E2E2E0] pb-2">Linimasa Pelaksanaan</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-slate-400">Mulai</p>
                    <p class="text-sm font-sans text-slate-700">{{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('d M Y, H:i') : 'Flexible' }}</p>
                </div>
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-slate-400">Selesai</p>
                    <p class="text-sm font-sans text-slate-700">{{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('d M Y, H:i') : 'Flexible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions List -->
    <div class="lg:col-span-2">
        <div class="harvard-card overflow-hidden">
            <div class="p-6 bg-[#F8F8F6] border-b border-[#E2E2E0]">
                <h3 class="font-serif font-bold text-xl text-[#1E1E1E]">Bank Soal Terdaftar</h3>
            </div>
            <div class="divide-y divide-[#E2E2E0]">
                @forelse($exam->questions as $index => $question)
                <div class="p-6 hover:bg-[#FBFBFA] transition-colors">
                    <div class="flex items-start gap-4">
                        <span class="w-8 h-8 bg-[#1E1E1E] flex items-center justify-center text-[#BD9B60] font-serif font-bold flex-shrink-0">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <div class="font-sans text-sm text-[#1E1E1E] leading-relaxed mb-4">
                                {!! $question->question_text !!}
                            </div>
                            
                            @if($question->type === 'multiple_choice')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @php $options = json_decode($question->options, true); @endphp
                                    @foreach($options as $key => $option)
                                        <div class="flex items-center p-3 border {{ $key === $question->correct_answer ? 'border-emerald-600 bg-emerald-50' : 'border-[#E2E2E0] bg-white' }}">
                                            <span class="text-[10px] font-bold uppercase mr-2 text-slate-400">{{ $key }}.</span>
                                            <span class="text-xs text-slate-700">{{ $option }}</span>
                                            @if($key === $question->correct_answer)
                                                <svg class="w-3.5 h-3.5 ml-auto text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-16 text-center text-slate-400 italic">
                    Belum ada butir soal yang ditambahkan ke ujian ini.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
