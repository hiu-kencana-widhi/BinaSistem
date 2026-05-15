<header class="bg-white border-b border-[#E9E9E7] h-20 flex items-center justify-between px-8 shrink-0 z-40 relative">
    <div class="flex items-center gap-6">
        <!-- Desktop Sidebar Toggle -->
        <button @click="toggleSidebar()" class="hidden md:flex text-slate-400 hover:text-[#A51C30] p-2 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 19l-7-7m0 0l7-7m-7 7h18" />
                <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = true" class="md:hidden text-slate-400 hover:text-[#A51C30] p-2 transition-colors">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Institution Status Badge -->
        <div class="hidden lg:flex items-center px-4 py-1.5 bg-[#F9F9F7] text-[#1E1E1E] border border-[#E9E9E7] text-[10px] font-black uppercase tracking-[0.2em]">
            <span class="mr-2.5 h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
            Academic Term: 2026/2027
        </div>
    </div>

    <div class="flex items-center gap-6">
        <!-- Academic Alerts -->
        <button class="text-slate-400 hover:text-[#A51C30] relative p-2 transition-colors">
            <span class="absolute top-2 right-2 block h-1.5 w-1.5 rounded-full bg-[#A51C30] ring-4 ring-white"></span>
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        <!-- Account Profile -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center gap-3 focus:outline-none group">
                <div class="h-9 w-9 bg-[#1E1E1E] flex items-center justify-center text-[#BD9B60] font-serif font-black text-xs shadow-md group-hover:bg-[#A51C30] transition-all">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="hidden md:flex flex-col items-start leading-none">
                    <span class="text-[11px] font-black text-[#1E1E1E] uppercase tracking-widest">{{ auth()->user()->name ?? 'Account' }}</span>
                    <span class="text-[9px] text-slate-400 uppercase tracking-widest mt-1">Profile View</span>
                </div>
            </button>

            <!-- Dropdown menu -->
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="transform opacity-0 -translate-y-2"
                 x-transition:enter-end="transform opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="transform opacity-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 -translate-y-2"
                 class="absolute right-0 z-50 mt-4 w-56 bg-white border border-[#E9E9E7] shadow-xl p-2 focus:outline-none" x-cloak>
                <div class="px-4 py-3 border-b border-[#F9F9F7] mb-2">
                    <p class="text-[9px] text-slate-400 uppercase tracking-widest">Authenticated</p>
                    <p class="text-xs font-bold text-[#1E1E1E] truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-[10px] font-black uppercase tracking-widest text-red-600 hover:bg-[#F9F9F7] transition-colors">
                        Terminate Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
