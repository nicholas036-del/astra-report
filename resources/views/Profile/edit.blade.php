@extends('layouts.app')
@section('title', 'Profil')
@section('content')
    <h1 class="mb-4 text-2xl font-bold">Profil Saya</h1>

    <form method="POST" action="{{ route('profile.update') }}"
          class="max-w-md space-y-4 rounded bg-white p-6 shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full rounded border border-gray-300 p-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full rounded border border-gray-300 p-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   required>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="rounded bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            Simpan
        </button>
    </form>
@endsection