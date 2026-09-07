@extends('layouts.app')
@section('title', 'Tambah Dealer')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Tambah Dealer</h1>
    <form method="POST" action="{{ route('supervisor.dealers.store') }}" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Kode Dealer</label>
            <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nama Dealer</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email Login Dealer</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full rounded border-gray-300">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Simpan</button>
            <a href="{{ route('supervisor.dealers.index') }}" class="px-4 py-2 rounded text-sm border">Batal</a>
        </div>
    </form>
@endsection
