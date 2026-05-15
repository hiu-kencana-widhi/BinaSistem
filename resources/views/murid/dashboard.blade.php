@extends('layouts.app')

@section('title', 'Student Portal')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Student Portfolio</h1>
        <p class="harvard-academic-subtitle">Academic Progress & Learning Resources</p>
    </div>
    <div class="hidden md:block text-right">
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Pending Assignments</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value text-[#A51C30]">{{ \App\Models\Assignment::where('classroom_id', Auth::user()->studentClassrooms()->first()->id ?? 0)->count() - \App\Models\AssignmentSubmission::where('student_id', Auth::id())->count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Academic Resources</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\Material::where('classroom_id', Auth::user()->studentClassrooms()->first()->id ?? 0)->count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>

    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Active Examinations</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\Exam::count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#A51C30] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>
    </div>
</div>

<h2 class="section-title">Academic Modules</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <a href="{{ route('murid.materials.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4 tracking-tight">E-Literature</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Access academic manuscripts and course materials.</p>
    </a>
    
    <a href="{{ route('murid.assignments.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4 tracking-tight">Assessments</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Track pending tasks and submit academic artifacts.</p>
    </a>

    <a href="{{ route('murid.exams.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4 tracking-tight">CBT Portal</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Participate in digital examinations and assessments.</p>
    </a>

    <a href="{{ route('murid.invoices.index') }}" class="harvard-card p-8 group hover:border-[#A51C30] transition-all">
        <h3 class="font-serif font-black text-lg text-[#1E1E1E] group-hover:text-[#A51C30] mb-4 tracking-tight">Bursary</h3>
        <p class="font-sans text-[10px] text-slate-400 uppercase tracking-widest leading-loose">Manage institutional fees and financial status.</p>
    </a>
</div>
@endsection
