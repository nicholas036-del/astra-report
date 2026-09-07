@extends('layouts.app')
@section('title', 'Edit Dealer')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Edit Dealer</h1>
    <form method="POST" action="{{ route('supervisor.dealers.update', $dealer) }}" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Kode Dealer</label>
            <input type="text" name="code" value="{{ old('code', $dealer->code) }}" class="w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nama Dealer</label>
            <input type="text" name="name" value="{{ old('name', $dealer->name) }}" class="w-full rounded border-gray-300">
        </div>
        <p class="text-xs text-gray-500">Email dan password akun login dealer dikelola terpisah dari halaman ini.</p>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Perbarui</button>
            <a href="{{ route('supervisor.dealers.index') }}" class="px-4 py-2 rounded text-sm border">Batal</a>
        </div>
    </form>
@endsection
