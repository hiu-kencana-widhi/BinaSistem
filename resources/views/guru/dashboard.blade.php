@extends('layouts.app')

@section('title', 'Faculty Portal')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Faculty Dashboard</h1>
        <p class="harvard-academic-subtitle">Academic Management & Student Evaluation</p>
    </div>
    <div class="hidden md:block text-right">
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Total Manuscripts</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\Material::where('teacher_id', Auth::id())->count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Active Assignments</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\Assignment::where('teacher_id', Auth::id())->count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>
    </div>

    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Pending Evaluations</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\AssignmentSubmission::whereHas('assignment', function($q) { $q->where('teacher_id', Auth::id()); })->whereNull('score')->count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#A51C30] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </div>
        </div>
    </div>
</div>

<h2 class="section-title">Academic Functions</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <a href="{{ route('guru.materials.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4">Manuscripts</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Publish academic resources and literature.</p>
    </a>
    
    <a href="{{ route('guru.assignments.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4">Assignments</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Manage student tasks and evaluation cycles.</p>
    </a>

    <a href="{{ route('guru.exams.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4">Examinations</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Configure digital CBT and assessments.</p>
    </a>

    <a href="{{ route('guru.attendances.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4">Registry</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Daily academic attendance and records.</p>
    </a>
</div>
@endsection
