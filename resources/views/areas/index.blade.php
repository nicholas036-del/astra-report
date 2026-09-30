@extends('layouts.app')
@section('title', 'Area')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-bold">Data Area</h1>
        <a href="{{ route('areas.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white">Tambah</a>
    </div>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($areas as $area)
                    <tr class="border-t">
                        <td class="p-3">{{ $area->name }}</td>
                        <td class="p-3">{{ $area->description }}</td>
                        <td class="flex gap-2 p-3">
                            <a href="{{ route('areas.edit', $area) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('areas.destroy', $area) }}"
                                  onsubmit="return confirm('Hapus area ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-3 text-center text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $areas->links() }}</div>
@endsection