@extends('layouts.app')
@section('title', 'Edit Departemen')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Edit Departemen</h1>
    <form method="POST" action="{{ route('supervisor.departments.update', $department) }}" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Kode Departemen</label>
            <input type="text" name="code" value="{{ old('code', $department->code) }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nama Departemen</label>
            <input type="text" name="name" value="{{ old('name', $department->name) }}" class="w-full rounded border-gray-300">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Perbarui</button>
            <a href="{{ route('supervisor.departments.index') }}" class="px-4 py-2 rounded text-sm border">Batal</a>
        </div>
    </form>
@endsection
