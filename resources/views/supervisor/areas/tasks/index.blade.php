@extends('layouts.app')
@section('title', 'Tugas')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">Manajemen Tugas</h1>
        <a href="{{ route('supervisor.tasks.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ Buat Tugas</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-2">Nama Laporan</th>
                    <th class="px-4 py-2">Departemen</th>
                    <th class="px-4 py-2">Area</th>
                    <th class="px-4 py-2">Batas Waktu</th>
                    <th class="px-4 py-2">Pengumpulan</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($tasks as $task)
                    <tr>
                        <td class="px-4 py-2">{{ $task->title }}</td>
                        <td class="px-4 py-2">{{ $task->department->name }}</td>
                        <td class="px-4 py-2">{{ $task->area->name }}</td>
                        <td class="px-4 py-2">{{ $task->due_at->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">{{ $task->submissions_count }} dealer</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            @if ($task->submissions_count === 0)
                                <a href="{{ route('supervisor.tasks.edit', $task) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('supervisor.tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            @else
                                <span class="text-gray-400">Terkunci</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tasks->links() }}</div>
@endsection
