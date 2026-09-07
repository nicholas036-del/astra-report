@extends('layouts.app')
@section('title', 'Departemen')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">Manajemen Departemen</h1>
        <a href="{{ route('supervisor.departments.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ Tambah Departemen</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($departments as $department)
                    <tr>
                        <td class="px-4 py-2">{{ $department->code }}</td>
                        <td class="px-4 py-2">{{ $department->name }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('supervisor.departments.edit', $department) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('supervisor.departments.destroy', $department) }}" method="POST" class="inline" onsubmit="return confirm('Hapus departemen ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data departemen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $departments->links() }}</div>
@endsection
