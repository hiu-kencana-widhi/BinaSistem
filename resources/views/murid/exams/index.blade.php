@extends('layouts.app')

@section('title', 'Computer Based Test')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Portal Evaluasi Digital</h1>
        <p class="harvard-academic-subtitle">Daftar ujian dan asesmen kompetensi mahasiswa.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($exams as $exam)
        @php
            $isDone = $exam->result !== null;
            $now = \Carbon\Carbon::now();
            $isOpen = (!$exam->start_time || $now->greaterThanOrEqualTo($exam->start_time)) && (!$exam->end_time || $now->lessThanOrEqualTo($exam->end_time));
            $isClosed = $exam->end_time && $now->greaterThan($exam->end_time);
            $isUpcoming = $exam->start_time && $now->lessThan($exam->start_time);
        @endphp
        
        <div class="harvard-card flex flex-col group transition-all duration-300 {{ $isDone ? 'border-emerald-600/30' : ($isOpen ? 'border-[#A51C30]/40' : 'border-[#E2E2E0]') }}">
            <div class="p-8 flex-1 relative">
                <div class="flex justify-between items-start mb-6">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#A51C30] bg-[#F3F3F1] px-2 py-1 border border-[#E2E2E0]">
                        {{ $exam->subject->name ?? 'GENERAL' }}
                    </span>
                    @if($isDone)
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-emerald-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Completed
                        </span>
                    @elseif($isClosed)
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" /></svg>
                            Expired
                        </span>
                    @elseif($isUpcoming)
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-[#BD9B60]">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Upcoming
                        </span>
                    @elseif($isOpen)
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-blue-600 animate-pulse">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                            In Progress
                        </span>
                    @endif
                </div>
                
                <h3 class="font-serif font-black text-2xl text-[#1E1E1E] mb-4 leading-tight group-hover:text-[#A51C30] transition-colors">{{ $exam->title }}</h3>
                
                <div class="space-y-3 font-sans text-[11px] uppercase tracking-widest text-slate-500">
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 mr-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Duration: <span class="font-bold text-[#1E1E1E] ml-1">{{ $exam->duration_minutes }} Minutes</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 mr-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Commences: <span class="ml-1">{{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('d M Y, H:i') : 'Indefinite' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="px-8 py-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
                @if($isDone)
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Academic Score</span>
                        <div class="text-3xl font-serif font-black {{ $exam->result->score >= 75 ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $exam->result->score }}<span class="text-xs text-slate-300 font-sans font-bold">/100</span>
                        </div>
                    </div>
                @elseif($isOpen && !$isDone)
                    <a href="{{ route('murid.exams.show', $exam) }}" onclick="return confirm('Anda akan memulai evaluasi formal. Waktu akan berjalan secara kontinu. Lanjutkan?');" class="harvard-btn-primary block w-full text-center !text-[10px]">
                        Begin Examination
                    </a>
                @elseif($isClosed && !$isDone)
                    <button disabled class="w-full text-center px-4 py-3 bg-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-widest cursor-not-allowed">
                        Period Concluded
                    </button>
                @elseif($isUpcoming)
                    <button disabled class="w-full text-center px-4 py-3 bg-[#F3F3F1] text-slate-400 text-[10px] font-bold uppercase tracking-widest cursor-not-allowed border border-[#E2E2E0]">
                        Access Pending
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full harvard-card p-20 text-center">
            <svg class="w-16 h-16 text-slate-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <p class="font-serif text-xl text-slate-400 italic">No formal examinations currently scheduled for your profile.</p>
        </div>
    @endforelse
</div>
@endsection
