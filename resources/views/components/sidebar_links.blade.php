@php
    $role = Auth::user()->getRoleNames()->first();
@endphp

<div class="space-y-2">
    @if($role === 'super-admin')
        <div class="px-8 mb-6 overflow-hidden transition-all duration-300" :class="sidebarOpen ? 'opacity-100 h-auto' : 'opacity-0 h-0 px-0'">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">Administrative</span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="harvard-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Command Center">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Command Center</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="harvard-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Civitas Registry">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Civitas Registry</span>
        </a>
        <a href="{{ route('admin.classrooms.index') }}" class="harvard-nav-link {{ request()->routeIs('admin.classrooms.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Academic Spaces">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Academic Spaces</span>
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="harvard-nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Curriculum">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Curriculum</span>
        </a>
        <a href="{{ route('admin.invoices.index') }}" class="harvard-nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Bursary">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Bursary</span>
        </a>
    @endif

    @if($role === 'guru')
        <div class="px-8 mb-6 overflow-hidden transition-all duration-300" :class="sidebarOpen ? 'opacity-100 h-auto' : 'opacity-0 h-0 px-0'">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">Faculty</span>
        </div>
        <a href="{{ route('guru.dashboard') }}" class="harvard-nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Faculty Desk">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Faculty Desk</span>
        </a>
        <a href="{{ route('guru.materials.index') }}" class="harvard-nav-link {{ request()->routeIs('guru.materials.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Manuscripts">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Manuscripts</span>
        </a>
        <a href="{{ route('guru.assignments.index') }}" class="harvard-nav-link {{ request()->routeIs('guru.assignments.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Evaluations">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Evaluations</span>
        </a>
        <a href="{{ route('guru.exams.index') }}" class="harvard-nav-link {{ request()->routeIs('guru.exams.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Examination">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Examination</span>
        </a>
    @endif

    @if($role === 'murid')
        <div class="px-8 mb-6 overflow-hidden transition-all duration-300" :class="sidebarOpen ? 'opacity-100 h-auto' : 'opacity-0 h-0 px-0'">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">Student</span>
        </div>
        <a href="{{ route('murid.dashboard') }}" class="harvard-nav-link {{ request()->routeIs('murid.dashboard') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Portfolio">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Portfolio</span>
        </a>
        <a href="{{ route('murid.materials.index') }}" class="harvard-nav-link {{ request()->routeIs('murid.materials.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="E-Literature">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">E-Literature</span>
        </a>
        <a href="{{ route('murid.assignments.index') }}" class="harvard-nav-link {{ request()->routeIs('murid.assignments.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Assessments">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Assessments</span>
        </a>
        <a href="{{ route('murid.exams.index') }}" class="harvard-nav-link {{ request()->routeIs('murid.exams.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Examination">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Examination</span>
        </a>
        <a href="{{ route('murid.invoices.index') }}" class="harvard-nav-link {{ request()->routeIs('murid.invoices.*') ? 'active' : '' }}" :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'" title="Bursary">
            <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-6' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Bursary</span>
        </a>
    @endif
</div>
