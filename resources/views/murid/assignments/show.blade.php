@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail Tugas</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $assignment->subject->name ?? 'Umum' }}</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('murid.assignments.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition-colors">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Tugas -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-4">{{ $assignment->title }}</h2>
                
                <div class="prose max-w-none text-slate-700 mb-6 text-sm">
                    {!! nl2br(e($assignment->instructions)) !!}
                </div>

                @if($assignment->attachment_path)
                    <div class="mt-4 border border-slate-200 rounded-md p-4 bg-slate-50">
                        <p class="text-sm font-medium text-slate-700 mb-2">Lampiran Tugas:</p>
                        <a href="{{ Storage::url($assignment->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Lampiran
                        </a>
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-wrap gap-4 text-sm text-slate-600">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium mr-1">Tenggat Waktu:</span> 
                    {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : 'Tanpa Batas Waktu' }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="font-medium mr-1">Guru:</span> 
                    {{ $assignment->teacher->name ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Status & Form Pengumpulan -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-6">
            <div class="p-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-md font-semibold text-slate-800">Status Pengumpulan</h3>
            </div>
            
            <div class="p-6">
                @php
                    $isOverdue = $assignment->due_date && \Carbon\Carbon::now()->greaterThan($assignment->due_date);
                @endphp

                @if($submission)
                    <!-- Jika Sudah Mengumpulkan -->
                    <div class="mb-6">
                        <div class="flex items-center text-emerald-600 mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold">Telah Dikumpulkan</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Pada: {{ $submission->submitted_at->format('d M Y, H:i') }}</p>
                        
                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat File Jawaban Saya
                        </a>
                    </div>

                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-sm font-medium text-slate-700 mb-1">Nilai:</p>
                        @if($submission->score !== null)
                            <div class="text-3xl font-bold {{ $submission->score >= 75 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $submission->score }}<span class="text-lg text-slate-400">/100</span>
                            </div>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                Menunggu Penilaian
                            </span>
                        @endif
                    </div>
                    
                @else
                    <!-- Jika Belum Mengumpulkan -->
                    @if($isOverdue)
                        <div class="p-4 bg-red-50 rounded-md border border-red-200 text-center">
                            <svg class="w-8 h-8 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm font-bold text-red-800">Waktu Habis</p>
                            <p class="text-xs text-red-600 mt-1">Anda tidak dapat lagi mengirimkan jawaban untuk tugas ini.</p>
                        </div>
                    @else
                        <form action="{{ route('murid.assignments.store', $assignment) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Unggah Jawaban (PDF/DOCX/ZIP max 20MB)</label>
                                <input type="file" name="file" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('file') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors" onclick="return confirm('Apakah Anda yakin jawaban sudah benar? File tidak dapat diubah setelah dikirim.');">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Kumpulkan Jawaban
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
