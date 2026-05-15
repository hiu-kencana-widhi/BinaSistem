@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Edit Data User</h1>
    <p class="text-sm text-slate-500 mt-1">Ubah informasi profil pengguna.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru (Biarkan kosong jika tidak diubah)</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                @error('phone') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
                @error('address') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Role/Peran *</label>
                @php $currentRole = $user->roles->first()->name ?? ''; @endphp
                <select name="role" required class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white" onchange="toggleClassroom(this.value)">
                    <option value="super-admin" {{ (old('role', $currentRole) == 'super-admin') ? 'selected' : '' }}>Super Admin</option>
                    <option value="guru" {{ (old('role', $currentRole) == 'guru') ? 'selected' : '' }}>Guru</option>
                    <option value="murid" {{ (old('role', $currentRole) == 'murid') ? 'selected' : '' }}>Murid</option>
                </select>
                @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div id="classroom-group" class="{{ old('role', $currentRole) == 'murid' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Kelas (Khusus Murid)</label>
                @php $currentClassroom = $user->classroomsAsStudent->first()->id ?? ''; @endphp
                <select name="classroom_id" class="w-full px-4 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="">Pilih Kelas...</option>
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ old('classroom_id', $currentClassroom) == $cls->id ? 'selected' : '' }}>{{ $cls->name }} ({{ $cls->level }})</option>
                    @endforeach
                </select>
                @error('classroom_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-4 flex justify-end space-x-3 border-t border-slate-200">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                Update User
            </button>
        </div>
    </form>
</div>

<script>
    function toggleClassroom(role) {
        const group = document.getElementById('classroom-group');
        if (role === 'murid') {
            group.classList.remove('hidden');
        } else {
            group.classList.add('hidden');
        }
    }
</script>
@endsection
