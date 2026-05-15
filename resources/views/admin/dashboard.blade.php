@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Institutional Overview</h1>
        <p class="harvard-academic-subtitle">BinaSistem Administrative Control Center</p>
    </div>
    <div class="hidden md:block text-right">
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
    <!-- Total Sivitas -->
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Total Civitas</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\User::count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>
    
    <!-- Total Ruang -->
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Academic Spaces</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\Classroom::count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>
    </div>

    <!-- Disiplin Ilmu -->
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Curriculum Subjects</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value group-hover:text-[#A51C30] transition-colors">{{ \App\Models\Subject::count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-[#BD9B60] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>

    <!-- Financial Realization -->
    <div class="harvard-stat-card group">
        <p class="harvard-stat-label">Financial Status</p>
        <div class="flex items-baseline justify-between w-full">
            <p class="harvard-stat-value text-emerald-700">{{ \App\Models\Invoice::where('status', 'paid')->count() }}</p>
            <div class="text-[#E9E9E7] group-hover:text-emerald-500 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<h2 class="section-title">Institutional Management</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
    <a href="{{ route('admin.users.index') }}" class="group harvard-card p-10 hover:border-[#BD9B60] block">
        <div class="flex items-center justify-between mb-8">
            <h3 class="font-serif font-black text-2xl text-[#1E1E1E] group-hover:text-[#A51C30] transition-colors tracking-tight">Civitas Registry</h3>
            <svg class="w-6 h-6 text-[#E9E9E7] group-hover:text-[#A51C30] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </div>
        <p class="font-sans text-xs text-slate-400 uppercase tracking-widest leading-loose">Comprehensive database management for faculty, staff, and students.</p>
    </a>

    <a href="{{ route('admin.classrooms.index') }}" class="group harvard-card p-10 hover:border-[#BD9B60] block">
        <div class="flex items-center justify-between mb-8">
            <h3 class="font-serif font-black text-2xl text-[#1E1E1E] group-hover:text-[#A51C30] transition-colors tracking-tight">Academic Structure</h3>
            <svg class="w-6 h-6 text-[#E9E9E7] group-hover:text-[#A51C30] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </div>
        <p class="font-sans text-xs text-slate-400 uppercase tracking-widest leading-loose">Configuration of physical learning spaces and academic advisor assignments.</p>
    </a>

    <a href="{{ route('admin.invoices.index') }}" class="group harvard-card p-10 hover:border-[#BD9B60] block">
        <div class="flex items-center justify-between mb-8">
            <h3 class="font-serif font-black text-2xl text-[#1E1E1E] group-hover:text-[#A51C30] transition-colors tracking-tight">Financial Services</h3>
            <svg class="w-6 h-6 text-[#E9E9E7] group-hover:text-[#A51C30] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </div>
        <p class="font-sans text-xs text-slate-400 uppercase tracking-widest leading-loose">Monitoring institutional obligations and auditing civitas financial transactions.</p>
    </a>
</div>
@endsection
