@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Direktori Ruang Akademik</h1>
        <p class="harvard-academic-subtitle">Pengaturan struktur kelas dan penugasan Wali Kelas.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('admin.classrooms.create') }}" class="harvard-btn-primary">
            Tambah Ruang Baru
        </a>
    </div>
</div>

<!-- Search -->
<div class="harvard-card p-6 mb-8 bg-[#F8F8F6]/50">
    <form action="{{ route('admin.classrooms.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau tingkat kelas..." 
                class="w-full bg-white border border-[#E2E2E0] px-4 py-2.5 text-sm font-sans focus:outline-none focus:border-[#A51C30] transition-colors">
        </div>
        <div>
            <button type="submit" class="harvard-btn-outline !py-2.5 !px-8 w-full md:w-auto">
                Cari Ruang
            </button>
        </div>
    </form>
</div>

<div class="harvard-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="harvard-data-table">
            <thead>
                <tr>
                    <th>Identitas Kelas</th>
                    <th>Tingkat</th>
                    <th>Departemen / Jurusan</th>
                    <th>Wali Kelas (Advisor)</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($classrooms as $classroom)
                <tr>
                    <td class="font-serif font-bold text-[#A51C30] text-lg">
                        {{ $classroom->name }}
                    </td>
                    <td>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-widest bg-[#F3F3F1] px-2 py-1 border border-[#E2E2E0]">
                            Level {{ $classroom->level }}
                        </span>
                    </td>
                    <td class="font-sans text-sm text-[#1E1E1E]">
                        {{ $classroom->major ? $classroom->major->name : '-' }}
                    </td>
                    <td>
                        <div class="flex items-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#BD9B60] mr-2"></div>
                            <span class="text-sm font-medium text-slate-700">{{ $classroom->teacher ? $classroom->teacher->name : 'Unassigned' }}</span>
                        </div>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.classrooms.edit', $classroom) }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-[#A51C30] transition-colors underline underline-offset-4">Modify</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-slate-400 italic">Database ruang akademik belum terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($classrooms->hasPages())
    <div class="p-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
        {{ $classrooms->links() }}
    </div>
    @endif
</div>
@endsection
