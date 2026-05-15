<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BinaSistem - Excellence in Academic Management</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo-BinaSistem.png') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .academic-gradient {
            background: linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%);
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23A51C30' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2v-4h4v-2H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-[#FDFDFB] text-[#1E1E1E] antialiased font-sans flex flex-col min-h-screen">

    <!-- Navigation Header -->
    <header class="bg-white/90 backdrop-blur-md border-b border-[#E9E9E7] fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-8 h-24 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('image/logo-BinaSistem.png') }}" alt="BinaSistem" class="h-12 w-auto">
                <div class="hidden md:block border-l border-[#E9E9E7] pl-4">
                    <span class="block font-serif font-black text-xl tracking-tight leading-none uppercase text-[#1E1E1E]">BinaSistem</span>
                    <span class="block text-[9px] text-[#A51C30] font-bold uppercase tracking-[0.3em] mt-1">Academic Registry</span>
                </div>
            </div>
            
            <nav class="flex items-center gap-8">
                <a href="#about" class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1E1E1E] hover:text-[#A51C30] transition-colors">Foundation</a>
                <a href="#portals" class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1E1E1E] hover:text-[#A51C30] transition-colors">Portals</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="harvard-btn-primary !py-2.5">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="harvard-btn-outline !py-2.5">Sign In</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <!-- Hero Section -->
        <section class="pt-48 pb-32 hero-pattern">
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="inline-block px-4 py-2 bg-[#F3F3F1] border border-[#E9E9E7] text-[10px] font-black uppercase tracking-[0.3em] text-[#A51C30]">
                        Established Excellence
                    </div>
                    <h1 class="font-serif text-6xl md:text-7xl lg:text-8xl text-[#1E1E1E] font-black leading-[0.9] tracking-tighter">
                        The Standard of <br><span class="text-[#A51C30]">Academic</span> Order.
                    </h1>
                    <p class="font-sans text-lg text-[#4A4A4A] max-w-xl leading-relaxed font-medium">
                        A prestigious management ecosystem designed for institutions that prioritize rigor, clarity, and the pursuit of intellectual distinction.
                    </p>
                    <div class="flex flex-wrap gap-6 pt-4">
                        <a href="{{ route('login') }}" class="harvard-btn-primary text-sm px-12 py-4">Access Global Portal</a>
                        <a href="#about" class="harvard-btn-outline text-sm px-12 py-4 group">
                            Explore Foundation
                            <svg class="inline-block w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="aspect-square bg-[#1E1E1E] shadow-2xl relative overflow-hidden group flex items-center justify-center p-24">
                        <!-- Logo inside the black box -->
                        <img src="{{ asset('image/logo-BinaSistem.png') }}" alt="BinaSistem" class="w-full h-full object-contain brightness-0 invert opacity-100 group-hover:scale-105 transition-transform duration-1000">
                        
                        <div class="absolute inset-0 border-[20px] border-[#A51C30]/10 m-8 pointer-events-none"></div>
                        <div class="absolute bottom-12 left-12 right-12">
                            <p class="text-[10px] font-black uppercase tracking-[0.5em] mb-4 text-[#BD9B60]">Official Registry</p>
                            <h3 class="font-serif text-3xl font-black italic text-white leading-tight">"Veritas Christo et Ecclesiae"</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Portals Grid -->
        <section id="portals" class="py-32 bg-[#F9F9F7] border-y border-[#E9E9E7]">
            <div class="max-w-7xl mx-auto px-8 text-center mb-24">
                <h2 class="font-serif text-4xl md:text-5xl font-black text-[#1E1E1E] mb-6">Institutional Gateways</h2>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-[#A51C30]">Choose Your Designated Access Point</p>
            </div>
            
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Faculty Portal -->
                <div class="harvard-card p-12 group hover:border-[#A51C30] transition-all bg-white shadow-sm">
                    <div class="w-16 h-16 bg-[#1E1E1E] flex items-center justify-center mb-10 group-hover:bg-[#A51C30] transition-colors shadow-lg">
                        <svg class="w-8 h-8 text-[#BD9B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-black text-[#1E1E1E] mb-4">Faculty Registry</h3>
                    <p class="text-xs text-[#1E1E1E] font-medium uppercase tracking-widest leading-loose mb-8 opacity-80">Managed curriculum delivery, manuscript publication, and formal student evaluation.</p>
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A51C30] border-b-2 border-[#A51C30] pb-1 hover:text-[#1E1E1E] hover:border-[#1E1E1E] transition-all">Faculty Sign In</a>
                </div>

                <!-- Student Portal -->
                <div class="harvard-card p-12 group hover:border-[#A51C30] transition-all bg-white shadow-sm">
                    <div class="w-16 h-16 bg-[#1E1E1E] flex items-center justify-center mb-10 group-hover:bg-[#A51C30] transition-colors shadow-lg">
                        <svg class="w-8 h-8 text-[#BD9B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.083 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-black text-[#1E1E1E] mb-4">Student Portfolio</h3>
                    <p class="text-xs text-[#1E1E1E] font-medium uppercase tracking-widest leading-loose mb-8 opacity-80">Centralized academic progress tracking, artifact submission, and bursary management.</p>
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A51C30] border-b-2 border-[#A51C30] pb-1 hover:text-[#1E1E1E] hover:border-[#1E1E1E] transition-all">Student Sign In</a>
                </div>

                <!-- Admin Portal -->
                <div class="harvard-card p-12 group hover:border-[#A51C30] transition-all bg-white shadow-sm">
                    <div class="w-16 h-16 bg-[#1E1E1E] flex items-center justify-center mb-10 group-hover:bg-[#A51C30] transition-colors shadow-lg">
                        <svg class="w-8 h-8 text-[#BD9B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-black text-[#1E1E1E] mb-4">Command Center</h3>
                    <p class="text-xs text-[#1E1E1E] font-medium uppercase tracking-widest leading-loose mb-8 opacity-80">Comprehensive institutional administration, civitas management, and financial auditing.</p>
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-[#A51C30] border-b-2 border-[#A51C30] pb-1 hover:text-[#1E1E1E] hover:border-[#1E1E1E] transition-all">Admin Sign In</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#1E1E1E] text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-4 gap-16 mb-24 border-b border-white/10 pb-24">
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('image/logo-BinaSistem.png') }}" alt="BinaSistem" class="h-16 w-auto brightness-0 invert opacity-100">
                    <div class="border-l border-white/20 pl-4">
                        <span class="block font-serif font-black text-3xl tracking-tight uppercase text-white">BinaSistem</span>
                        <span class="block text-[10px] text-[#BD9B60] font-bold uppercase tracking-[0.5em] mt-1">Institutional Excellence</span>
                    </div>
                </div>
                <p class="text-slate-300 font-sans text-sm max-w-md leading-loose uppercase tracking-widest font-medium opacity-90">
                    The BinaSistem platform is an elite academic registry system dedicated to maintaining the highest standards of institutional management and scholarly integrity.
                </p>
            </div>
            <div class="space-y-6">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-[#BD9B60]">Foundation</h4>
                <ul class="space-y-4 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-300">
                    <li><a href="#" class="hover:text-white transition-colors">Academic Ethics</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Institutional Privacy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">System Manifest</a></li>
                </ul>
            </div>
            <div class="space-y-6">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-[#BD9B60]">Contact</h4>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-300 leading-loose">
                    Main Administration Office<br>
                    Academic District, Tower IV<br>
                    contact@binasistem.edu
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em]">© 2026 BinaSistem Academic Registry. All Scholarly Rights Reserved.</p>
            <div class="flex gap-8 text-[9px] font-black text-slate-400 uppercase tracking-[0.4em]">
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">Privacy Charter</a>
            </div>
        </div>
    </footer>

</body>
</html>
