@extends('layouts.app')

@section('title', 'Kurikulum & Materi')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Katalog Kurikulum</h1>
        <p class="harvard-academic-subtitle">Daftar disiplin ilmu dan mata pelajaran akademik.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('admin.subjects.create') }}" class="harvard-btn-primary">
            Tambah Disiplin Ilmu
        </a>
    </div>
</div>

<!-- Search -->
<div class="harvard-card p-6 mb-8 bg-[#F8F8F6]/50">
    <form action="{{ route('admin.subjects.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan kode atau nama disiplin ilmu..." 
                class="w-full bg-white border border-[#E2E2E0] px-4 py-2.5 text-sm font-sans focus:outline-none focus:border-[#A51C30] transition-colors">
        </div>
        <div>
            <button type="submit" class="harvard-btn-outline !py-2.5 !px-8 w-full md:w-auto">
                Cari Katalog
            </button>
        </div>
    </form>
</div>

<div class="harvard-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="harvard-data-table">
            <thead>
                <tr>
                    <th>Kode Disiplin</th>
                    <th>Nama Mata Pelajaran</th>
                    <th>Kategori Kurikulum</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subjects as $subject)
                <tr>
                    <td class="font-sans font-bold text-slate-500 text-xs tracking-widest uppercase">
                        {{ $subject->code }}
                    </td>
                    <td class="font-serif font-bold text-[#1E1E1E] text-lg">
                        {{ $subject->name }}
                    </td>
                    <td>
                        <span class="text-[10px] font-bold text-[#BD9B60] uppercase tracking-widest bg-[#1E1E1E] px-2 py-1 border border-[#BD9B60]/30 shadow-inner">
                            {{ $subject->type ?? 'Mandatory' }}
                        </span>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-[#A51C30] transition-colors underline underline-offset-4">Modify</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-16 text-slate-400 italic">Katalog kurikulum belum terdaftar dalam sistem.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subjects->hasPages())
    <div class="p-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
        {{ $subjects->links() }}
    </div>
    @endif
</div>
@endsection
