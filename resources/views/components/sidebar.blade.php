<aside 
    id="sidebar"
    class="harvard-sidebar fixed left-0 top-0 h-full sidebar-transition z-50 overflow-y-auto"
    :class="sidebarOpen ? 'w-72' : 'w-20'"
>
    <!-- Brand Header -->
    <div class="h-24 flex items-center border-b border-[#2A2A2A] overflow-hidden bg-[#1E1E1E] sidebar-transition"
        :class="sidebarOpen ? 'px-8' : 'px-0 justify-center'">
        <div class="flex items-center gap-5" :class="sidebarOpen ? 'min-w-[240px]' : 'justify-center'">
            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                <img src="{{ asset('image/logo-BinaSistem.png') }}" alt="L" class="h-full w-full object-contain">
            </div>
            <div class="flex flex-col transition-all duration-300" 
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-x-4"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-4">
                <span class="text-white font-serif font-black text-lg tracking-tight leading-none uppercase">BinaSistem</span>
                <span class="text-[9px] text-[#BD9B60] font-bold uppercase tracking-[0.3em] mt-1">Academic</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="py-12">
        <div class="space-y-1">
            @include('components.sidebar_links')
        </div>
    </nav>

    <!-- User Profile Minimal -->
    <div class="absolute bottom-0 left-0 w-full border-t border-[#2A2A2A] bg-[#1E1E1E] p-4 overflow-hidden sidebar-transition"
        :class="sidebarOpen ? 'p-6' : 'p-0 h-24 flex items-center justify-center'">
        <div class="flex items-center gap-5" :class="sidebarOpen ? 'min-w-[240px]' : 'justify-center'">
            <div class="w-10 h-10 bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                <span class="text-white font-serif font-bold text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="flex flex-col transition-all duration-300" 
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-x-4"
                x-transition:enter-end="opacity-100 translate-x-0">
                <span class="text-white text-[11px] font-bold truncate tracking-wide uppercase">{{ Auth::user()->name }}</span>
                <span class="text-[9px] text-slate-500 uppercase tracking-widest mt-1">{{ Auth::user()->getRoleNames()->first() }}</span>
            </div>
        </div>
    </div>
</aside>
