@extends('layouts.app')

@section('title', 'Materi E-Learning')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Khazanah Pengetahuan</h1>
        <p class="harvard-academic-subtitle">Akses literatur dan materi kuliah terbaru Anda.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($materials as $material)
        <div class="harvard-card flex flex-col group transition-all duration-300 {{ $material->is_read ? 'border-[#BD9B60]/40' : 'border-[#E2E2E0]' }}">
            <div class="p-8 flex-1">
                <div class="flex justify-between items-start mb-6">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#A51C30] bg-[#F3F3F1] px-2 py-1 border border-[#E2E2E0]">
                        {{ $material->subject->name ?? 'GENERAL' }}
                    </span>
                    @if($material->is_read)
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-[#BD9B60]">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Completed
                        </span>
                    @endif
                </div>
                <h3 class="font-serif font-black text-2xl text-[#1E1E1E] mb-3 leading-tight group-hover:text-[#A51C30] transition-colors">{{ $material->title }}</h3>
                <p class="font-sans text-sm text-slate-500 line-clamp-3 mb-6 leading-relaxed">{{ $material->description }}</p>
                <div class="flex items-center text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Prof. {{ $material->teacher->name ?? '-' }}
                </div>
            </div>
            
            <div class="px-8 py-6 bg-[#F8F8F6] border-t border-[#E2E2E0] flex items-center justify-between">
                @if($material->file_path)
                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="harvard-btn-primary !py-2 !px-4 !text-[10px]">
                        Open Manuscript
                    </a>
                @else
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">No Resource</span>
                @endif

                @if(!$material->is_read)
                    <form action="{{ route('murid.materials.mark-read', $material) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-slate-600 hover:text-[#A51C30] transition-colors underline decoration-[#BD9B60] decoration-2 underline-offset-4">
                            Mark as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full harvard-card p-20 text-center">
            <svg class="w-16 h-16 text-slate-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <p class="font-serif text-xl text-slate-400 italic">No academic resources available for your current classroom.</p>
        </div>
    @endforelse
</div>
@endsection
