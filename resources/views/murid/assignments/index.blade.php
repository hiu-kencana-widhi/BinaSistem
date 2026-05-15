@extends('layouts.app')

@section('title', 'Tugas & Evaluasi')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Daftar Penugasan</h1>
        <p class="harvard-academic-subtitle">Kewajiban akademik dan evaluasi kompetensi mahasiswa.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($assignments as $assignment)
        @php
            $isOverdue = $assignment->due_date && \Carbon\Carbon::now()->greaterThan($assignment->due_date);
            $hasSubmitted = $assignment->submission !== null;
        @endphp
        
        <div class="harvard-card flex flex-col group transition-all duration-300 {{ $hasSubmitted ? 'border-emerald-600/30' : ($isOverdue ? 'border-red-600/30' : 'border-[#E2E2E0]') }}">
            <div class="p-8 flex-1 relative">
                @if($isOverdue && !$hasSubmitted)
                    <div class="absolute top-0 right-0 bg-red-600 text-white text-[9px] font-bold px-3 py-1 uppercase tracking-widest shadow-lg">
                        Overdue
                    </div>
                @endif
                
                <div class="flex justify-between items-start mb-6">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#A51C30] bg-[#F3F3F1] px-2 py-1 border border-[#E2E2E0]">
                        {{ $assignment->subject->name ?? 'GENERAL' }}
                    </span>
                    @if($hasSubmitted)
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-emerald-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Submitted
                        </span>
                    @endif
                </div>
                <h3 class="font-serif font-black text-2xl text-[#1E1E1E] mb-3 leading-tight group-hover:text-[#A51C30] transition-colors">{{ $assignment->title }}</h3>
                
                <div class="text-[10px] font-bold uppercase tracking-widest mb-6 flex items-center {{ $isOverdue && !$hasSubmitted ? 'text-red-600' : 'text-slate-400' }}">
                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Deadline: {{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') : 'Indefinite' }}
                </div>
                
                <div class="flex items-center text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Prof. {{ $assignment->teacher->name ?? '-' }}
                </div>
            </div>
            
            <div class="px-8 py-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
                <a href="{{ route('murid.assignments.show', $assignment) }}" class="harvard-btn-primary block w-full text-center !text-[10px]">
                    Review & Submit Artifacts
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full harvard-card p-20 text-center">
            <svg class="w-16 h-16 text-slate-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <p class="font-serif text-xl text-slate-400 italic">No academic assignments found for your current curriculum.</p>
        </div>
    @endforelse
</div>
@endsection
