@extends('layouts.app')
@section('title', 'Dealer')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-bold">Data Dealer</h1>
        <a href="{{ route('dealers.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white">Tambah</a>
    </div>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Alamat</th>
                    <th class="p-3">Telepon</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dealers as $dealer)
                    <tr class="border-t">
                        <td class="p-3">{{ $dealer->code }}</td>
                        <td class="p-3">{{ $dealer->name }}</td>
                        <td class="p-3">{{ $dealer->address }}</td>
                        <td class="p-3">{{ $dealer->phone }}</td>
                        <td class="flex gap-2 p-3">
                            <a href="{{ route('dealers.edit', $dealer) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('dealers.destroy', $dealer) }}"
                                  onsubmit="return confirm('Hapus dealer ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-3 text-center text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $dealers->links() }}</div>
@endsection