@extends('layouts.app')

@section('title', 'Buat Penugasan Baru')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Registrasi Penugasan</h1>
        <p class="harvard-academic-subtitle">Formulir penerbitan tugas akademik baru.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('guru.assignments.index') }}" class="harvard-btn-outline">
            Kembali ke Daftar
        </a>
    </div>
</div>

<div class="max-w-3xl">
    <div class="harvard-card p-8">
        <form action="{{ route('guru.assignments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="harvard-stat-label block mb-2">Judul Penugasan</label>
                <input type="text" name="title" required class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 font-serif text-lg focus:outline-none focus:border-[#A51C30] transition-colors" placeholder="Masukkan judul penugasan...">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="harvard-stat-label block mb-2">Batas Waktu (Due Date)</label>
                    <input type="datetime-local" name="due_date" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors">
                </div>
                <div>
                    <label class="harvard-stat-label block mb-2">Lampiran Soal (Opsional)</label>
                    <input type="file" name="attachment" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-2.5 text-xs focus:outline-none focus:border-[#A51C30] transition-colors">
                </div>
            </div>

            <div>
                <label class="harvard-stat-label block mb-2">Instruksi Penugasan</label>
                <textarea name="instructions" rows="6" class="w-full bg-[#F8F8F6] border border-[#E2E2E0] px-4 py-3 text-sm focus:outline-none focus:border-[#A51C30] transition-colors" placeholder="Berikan instruksi detail pengerjaan tugas..."></textarea>
            </div>

            <div class="pt-4 border-t border-[#E2E2E0]">
                <button type="submit" class="harvard-btn-primary w-full md:w-auto px-12">
                    Terbitkan Penugasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
