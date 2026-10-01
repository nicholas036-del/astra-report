@extends('layouts.app')
@section('title', 'Profil')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Profil Saya</h1>

    <form method="POST" action="{{ route('profile.update') }}" class="mb-6 rounded bg-white p-4 shadow">
        @csrf
        @method('PUT')

        <h2 class="mb-3 font-bold">Data akun</h2>

        <div class="mb-3">
            <label class="block text-sm font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded border p-2">
            @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded border p-2">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3 text-sm text-gray-600">
            Role: {{ $user->role }}
            @if ($user->dealer)
                | Dealer: {{ $user->dealer->name }}
            @endif
        </div>

        <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan</button>
    </form>

    <form method="POST" action="{{ route('profile.password') }}" class="rounded bg-white p-4 shadow">
        @csrf
        @method('PUT')

        <h2 class="mb-3 font-bold">Ganti password</h2>

        <div class="mb-3">
            <label class="block text-sm font-medium">Password lama</label>
            <input type="password" name="current_password" class="w-full rounded border p-2" autocomplete="current-password">
            @error('current_password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium">Password baru (minimal 8 karakter)</label>
            <input type="password" name="password" class="w-full rounded border p-2" autocomplete="new-password">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium">Konfirmasi password baru</label>
            <input type="password" name="password_confirmation" class="w-full rounded border p-2" autocomplete="new-password">
        </div>

        <button class="rounded bg-blue-600 px-4 py-2 text-white">Ganti password</button>
    </form>
@endsection