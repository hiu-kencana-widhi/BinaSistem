@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="harvard-academic-header">
    <div>
        <h1 class="harvard-academic-title">Registrasi Sivitas</h1>
        <p class="harvard-academic-subtitle">Manajemen database seluruh pengguna sistem akademik.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('admin.users.create') }}" class="harvard-btn-primary">
            Tambah Sivitas Baru
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="harvard-card p-6 mb-8 bg-[#F8F8F6]/50">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau email..." 
                class="w-full bg-white border border-[#E2E2E0] px-4 py-2.5 text-sm font-sans focus:outline-none focus:border-[#A51C30] transition-colors">
        </div>
        <div class="md:w-64">
            <select name="role" class="w-full bg-white border border-[#E2E2E0] px-4 py-2.5 text-sm font-sans focus:outline-none focus:border-[#A51C30] transition-colors appearance-none">
                <option value="">Seluruh Jabatan</option>
                <option value="super-admin" {{ request('role') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru / Pengajar</option>
                <option value="murid" {{ request('role') == 'murid' ? 'selected' : '' }}>Murid / Mahasiswa</option>
            </select>
        </div>
        <div>
            <button type="submit" class="harvard-btn-outline !py-2.5 !px-8 w-full md:w-auto">
                Filter
            </button>
        </div>
    </form>
</div>

<div class="harvard-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="harvard-data-table">
            <thead>
                <tr>
                    <th>Nama & Identitas</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th class="text-right">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center">
                            <div class="h-9 w-9 bg-[#1E1E1E] border border-[#BD9B60]/30 flex items-center justify-center text-[#BD9B60] font-serif font-bold text-xs shadow-inner">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-serif font-bold text-[#1E1E1E]">{{ $user->name }}</div>
                                <div class="text-[11px] text-slate-400 font-sans tracking-wide uppercase">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 border border-[#BD9B60]/20 text-[#A51C30] bg-[#F3F3F1]">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 flex items-center">
                                <span class="w-1.5 h-1.5 bg-emerald-600 rounded-full mr-2"></span>
                                Aktif
                            </span>
                        @else
                            <span class="text-[10px] font-bold uppercase tracking-widest text-red-600 flex items-center">
                                <span class="w-1.5 h-1.5 bg-red-600 rounded-full mr-2"></span>
                                Suspend
                            </span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-[#A51C30] transition-colors underline underline-offset-4">Edit</a>
                            
                            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-amber-600 transition-colors underline underline-offset-4" onclick="return confirm('Reset password?')">Reset</button>
                            </form>

                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest {{ $user->is_active ? 'text-red-400 hover:text-red-600' : 'text-emerald-400 hover:text-emerald-600' }} transition-colors underline underline-offset-4">
                                    {{ $user->is_active ? 'Suspend' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-16 text-slate-400 italic">Database sivitas akademik belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-6 bg-[#F8F8F6] border-t border-[#E2E2E0]">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
