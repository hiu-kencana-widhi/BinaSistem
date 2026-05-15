@extends('layouts.app')

@section('title', 'Tambah Soal Ujian')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Soal Ujian</h1>
        <p class="text-sm text-slate-500 mt-1">Ujian: <span class="font-semibold">{{ $exam->title }}</span></p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('guru.exams.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition-colors">
            Kembali ke Daftar Ujian
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Form Tambah Soal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-semibold text-slate-800">Tambah Soal Baru</h3>
                <p class="text-sm text-slate-500 mt-1">Isi detail soal dan tentukan jawaban yang benar.</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('guru.questions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pertanyaan</label>
                            <textarea name="question_text" rows="4" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('question_text') }}</textarea>
                            @error('question_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilihan A</label>
                                <input type="text" name="option_a" value="{{ old('option_a') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('option_a') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilihan B</label>
                                <input type="text" name="option_b" value="{{ old('option_b') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('option_b') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilihan C</label>
                                <input type="text" name="option_c" value="{{ old('option_c') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('option_c') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilihan D</label>
                                <input type="text" name="option_d" value="{{ old('option_d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('option_d') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="pt-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Kunci Jawaban</label>
                            <div class="flex space-x-4">
                                @foreach(['A', 'B', 'C', 'D'] as $opt)
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="correct_answer_char" value="{{ $opt }}" class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300" {{ old('correct_answer_char') == $opt ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-slate-700">{{ $opt }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('correct_answer_char') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-slate-900 hover:bg-slate-800 shadow-sm transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Simpan & Tambah Soal Lagi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Soal Terinput -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-6">
            <div class="p-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h3 class="text-md font-semibold text-slate-800">Soal Tersimpan</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $exam->questions->count() }} Soal
                </span>
            </div>
            
            <div class="p-0 max-h-[600px] overflow-y-auto">
                <ul class="divide-y divide-slate-200">
                    @forelse ($exam->questions as $index => $question)
                        <li class="p-4 hover:bg-slate-50 transition-colors">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $index + 1 }}. {{ Str::limit($question->question_text, 50) }}</p>
                                    <p class="text-xs text-emerald-600 mt-1 font-semibold">Kunci: {{ $question->correct_answer_char }}</p>
                                </div>
                                <form action="{{ route('guru.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-center text-sm text-slate-500">
                            Belum ada soal.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
