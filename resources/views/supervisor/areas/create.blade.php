@extends('layouts.app')
@section('title', 'Tambah Area')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Tambah Area</h1>
    <form method="POST" action="{{ route('supervisor.areas.store') }}" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Kode Area</label>
            <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nama Area</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded border-gray-300">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Simpan</button>
            <a href="{{ route('supervisor.areas.index') }}" class="px-4 py-2 rounded text-sm border">Batal</a>
        </div>
    </form>
@endsection
