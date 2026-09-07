@extends('layouts.app')
@section('title', 'Dealer')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">Manajemen Dealer</h1>
        <a href="{{ route('supervisor.dealers.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ Tambah Dealer</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Akun Login</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($dealers as $dealer)
                    <tr>
                        <td class="px-4 py-2">{{ $dealer->code }}</td>
                        <td class="px-4 py-2">{{ $dealer->name }}</td>
                        <td class="px-4 py-2">{{ $dealer->user?->email ?? '-' }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('supervisor.dealers.edit', $dealer) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('supervisor.dealers.destroy', $dealer) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dealer ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data dealer.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $dealers->links() }}</div>
@endsection
