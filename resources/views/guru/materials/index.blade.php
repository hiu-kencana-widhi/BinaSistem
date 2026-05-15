@extends('layouts.app')

@section('title', 'Manajemen Materi')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Khazanah Materi</h1>
        <p class="harvard-academic-subtitle">Koleksi literatur dan materi perkuliahan Anda.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.materials.create') }}" class="harvard-btn-primary">
            Unggah Materi Baru
        </a>
    </div>
</div>

<div class="harvard-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="harvard-data-table">
            <thead>
                <tr>
                    <th>Judul Materi</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Tanggal Terbit</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr>
                    <td class="font-serif font-bold text-[#A51C30]">{{ $material->title }}</td>
                    <td>{{ $material->subject->name }}</td>
                    <td><span class="bg-[#F3F3F1] px-2 py-1 border border-[#E2E2E0] text-[10px] font-bold uppercase tracking-tight">{{ $material->classroom->name }}</span></td>
                    <td class="text-slate-500 text-xs">{{ $material->created_at->format('d M Y, H:i') }}</td>
                    <td class="text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase tracking-widest">Unduh</a>
                            <form action="{{ route('guru.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold uppercase tracking-widest">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-400 italic">Belum ada materi yang diunggah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 bg-[#F8F8F6]">
        {{ $materials->links() }}
    </div>
</div>
@endsection
