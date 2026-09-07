@extends('layouts.app')
@section('title', 'Edit Tugas')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Edit Tugas</h1>
    <form method="POST" action="{{ route('supervisor.tasks.update', $task) }}" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Nama Laporan</label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Departemen</label>
            <select name="department_id" class="w-full rounded border-gray-300">
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $task->department_id) == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Area</label>
            <select name="area_id" class="w-full rounded border-gray-300">
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected(old('area_id', $task->area_id) == $area->id)>{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Batas Waktu</label>
            <input type="date" name="due_at" value="{{ old('due_at', $task->due_at->toDateString()) }}" class="w-full rounded border-gray-300">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Perbarui</button>
            <a href="{{ route('supervisor.tasks.index') }}" class="px-4 py-2 rounded text-sm border">Batal</a>
        </div>
    </form>
@endsection
