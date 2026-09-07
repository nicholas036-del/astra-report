@extends('layouts.app')
@section('title', 'Buat Tugas')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Buat Tugas Baru</h1>
    <form method="POST" action="{{ route('supervisor.tasks.store') }}" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nama Laporan</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Departemen</label>
            <select name="department_id" class="w-full rounded border-gray-300">
                <option value="">-- Pilih Departemen --</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Area</label>
            <select name="area_id" class="w-full rounded border-gray-300">
                <option value="">-- Pilih Area --</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected(old('area_id') == $area->id)>{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Batas Waktu</label>
            <input type="date" name="due_at" value="{{ old('due_at', now()->toDateString()) }}" class="w-full rounded border-gray-300">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Simpan</button>
            <a href="{{ route('supervisor.tasks.index') }}" class="px-4 py-2 rounded text-sm border">Batal</a>
        </div>
    </form>
@endsection
