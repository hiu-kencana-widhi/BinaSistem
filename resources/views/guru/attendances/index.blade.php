@extends('layouts.app')

@section('title', 'Rekap Absensi Harian')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Rekap Absensi Harian</h1>
    <p class="text-sm text-slate-500 mt-1">Kelola absensi siswa di kelas yang Anda ampu.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <div class="p-6 bg-slate-50 border-b border-slate-200">
        <form action="{{ route('guru.attendances.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Kelas</label>
                <select name="classroom_id" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ (isset($selectedClassroom) && $selectedClassroom->id == $cls->id) ? 'selected' : '' }}>
                            {{ $cls->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition-colors">
                    Tampilkan Data
                </button>
            </div>
        </form>
    </div>
</div>

@if(isset($selectedClassroom))
    <form action="{{ route('guru.attendances.store') }}" method="POST">
        @csrf
        <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Daftar Siswa Kelas {{ $selectedClassroom->name }}</h3>
                <span class="text-sm font-medium text-slate-500">Tanggal: {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-16">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Kehadiran (H/S/I/A)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($students as $index => $student)
                            @php
                                $currentStatus = isset($attendances[$student->id]) ? $attendances[$student->id]->status : 'H';
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="inline-flex space-x-4">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="status[{{ $student->id }}]" value="H" class="form-radio h-4 w-4 text-emerald-600 focus:ring-emerald-500" {{ $currentStatus == 'H' ? 'checked' : '' }}>
                                            <span class="ml-1 text-sm text-slate-700">H</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="status[{{ $student->id }}]" value="S" class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500" {{ $currentStatus == 'S' ? 'checked' : '' }}>
                                            <span class="ml-1 text-sm text-slate-700">S</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="status[{{ $student->id }}]" value="I" class="form-radio h-4 w-4 text-amber-500 focus:ring-amber-400" {{ $currentStatus == 'I' ? 'checked' : '' }}>
                                            <span class="ml-1 text-sm text-slate-700">I</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="status[{{ $student->id }}]" value="A" class="form-radio h-4 w-4 text-red-600 focus:ring-red-500" {{ $currentStatus == 'A' ? 'checked' : '' }}>
                                            <span class="ml-1 text-sm text-slate-700">A</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada siswa di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($students->count() > 0)
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                        Simpan Absensi
                    </button>
                </div>
            @endif
        </div>
    </form>
@endif

@endsection
