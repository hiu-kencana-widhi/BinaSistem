@extends('layouts.app')

@section('title', 'Unggah Materi')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Registrasi Materi</h1>
        <p class="harvard-academic-subtitle">Lengkapi detail untuk menerbitkan materi baru.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.materials.index') }}" class="harvard-btn-outline">
            Kembali ke Daftar
        </a>
    </div>
</div>

<div class="max-w-2xl">
    <div class="harvard-card p-8">
        <form action="{{ route('guru.materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="harvard-stat-label block mb-2">Judul Materi</label>
                <input type="text" name="title" required class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 font-serif text-lg focus:outline-none focus:border-[#A51C30] transition-colors" placeholder="Masukkan judul materi...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="harvard-stat-label block mb-2">Mata Pelajaran</label>
                    <select name="subject_id" required class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors appearance-none">
                        <option value="">Pilih Mapel</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="harvard-stat-label block mb-2">Target Kelas</label>
                    <select name="classroom_id" required class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors appearance-none">
                        <option value="">Pilih Kelas</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="harvard-stat-label block mb-2">Deskripsi Materi</label>
                <textarea name="description" rows="4" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors" placeholder="Berikan deskripsi singkat tentang materi ini..."></textarea>
            </div>

            <div class="border-2 border-dashed border-[#E2E2E0] p-8 text-center bg-[#F8F8F6]">
                <label class="cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-slate-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="mt-2 block text-sm font-semibold text-slate-600">Klik untuk unggah file</span>
                    <span class="mt-1 block text-xs text-slate-500">PDF, MP4, MKV (Maks. 50MB)</span>
                    <input type="file" name="file" required class="hidden">
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="harvard-btn-primary w-full text-center flex justify-center">
                    Terbitkan Materi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
