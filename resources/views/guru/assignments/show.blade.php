@extends('layouts.app')

@section('title', 'Evaluasi Akademik')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Lembar Evaluasi</h1>
        <p class="harvard-academic-subtitle">Koreksi dan penilaian tugas: {{ $assignment->title }}</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.assignments.index') }}" class="harvard-btn-outline">
            Kembali ke Daftar
        </a>
    </div>
</div>

<div class="harvard-card overflow-hidden mb-8">
    <div class="p-8 border-b border-[#E2E2E0] bg-[#F8F8F6]">
        <h3 class="font-serif font-bold text-xl text-[#1E1E1E] mb-2">Daftar Manifest Submisi</h3>
        <p class="font-sans text-xs text-slate-500 uppercase tracking-widest">Berikan penilaian numerik (0-100) pada kolom yang tersedia.</p>
    </div>
    
    <form action="{{ route('guru.assignments.mass-grade', $assignment) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="overflow-x-auto">
            <table class="harvard-data-table">
                <thead>
                    <tr>
                        <th>Identitas Mahasiswa</th>
                        <th>Kronologi Pengumpulan</th>
                        <th>Artefak Tugas</th>
                        <th class="w-40 text-center">Skor Akademik</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assignment->submissions as $submission)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-[#1E1E1E] flex items-center justify-center text-[#BD9B60] font-serif font-bold text-[10px]">
                                    {{ strtoupper(substr($submission->student->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-serif font-bold text-[#1E1E1E]">{{ $submission->student->name ?? 'Unknown' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-xs text-slate-500 font-sans">
                            {{ $submission->submitted_at ? \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y, H:i') : '-' }}
                        </td>
                        <td>
                            @if($submission->file_path)
                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-[10px] font-bold uppercase tracking-widest text-[#A51C30] hover:underline decoration-[#BD9B60] decoration-2 underline-offset-4 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Review File
                                </a>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">No Submission</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <input type="number" 
                                   name="scores[{{ $submission->id }}]" 
                                   value="{{ $submission->score }}" 
                                   min="0" max="100" 
                                   class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-3 py-2 text-sm font-serif font-bold text-center focus:outline-none focus:border-[#A51C30] transition-colors"
                                   placeholder="0">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-16 text-slate-400 italic">Belum ada submisi yang masuk untuk penugasan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($assignment->submissions->count() > 0)
        <div class="p-8 bg-[#F8F8F6] border-t border-[#E2E2E0] text-right">
            <button type="submit" class="harvard-btn-primary !px-10">
                Finalisasi & Simpan Nilai
            </button>
        </div>
        @endif
    </form>
</div>
@endsection
