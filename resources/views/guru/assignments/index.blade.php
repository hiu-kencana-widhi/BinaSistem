@extends('layouts.app')

@section('title', 'Manajemen Tugas')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Penugasan Akademik</h1>
        <p class="harvard-academic-subtitle">Evaluasi dan manajemen tugas mahasiswa.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.assignments.create') }}" class="harvard-btn-primary">
            Buat Tugas Baru
        </a>
    </div>
</div>

<div class="harvard-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="harvard-data-table">
            <thead>
                <tr>
                    <th>Judul Tugas</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Batas Waktu</th>
                    <th>Submisi</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $assignment)
                <tr>
                    <td class="font-serif font-bold text-[#A51C30]">{{ $assignment->title }}</td>
                    <td>{{ $assignment->subject->name }}</td>
                    <td><span class="bg-[#F3F3F1] px-2 py-1 border border-[#E2E2E0] text-[10px] font-bold uppercase tracking-tight">{{ $assignment->classroom->name }}</span></td>
                    <td class="text-slate-500 text-xs font-sans">
                        @if($assignment->due_date)
                            {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}
                        @else
                            <span class="italic text-slate-300">No Deadline</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center">
                            <span class="text-sm font-bold text-[#1E1E1E]">{{ $assignment->submissions->count() }}</span>
                            <span class="text-[10px] text-slate-400 ml-1 uppercase tracking-widest">dikumpulkan</span>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('guru.assignments.show', $assignment) }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-[#A51C30] transition-colors underline underline-offset-4">Koreksi</a>
                            <form action="{{ route('guru.assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors underline underline-offset-4">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-16 text-slate-400 italic font-serif text-lg">Belum ada penugasan akademik yang diterbitkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($assignments->hasPages())
    <div class="p-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
        {{ $assignments->links() }}
    </div>
    @endif
</div>
@endsection
