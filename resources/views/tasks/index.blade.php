@extends('layouts.app')
@section('title', 'Task')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-bold">Data Task</h1>
        <a href="{{ route('tasks.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white">Tambah</a>
    </div>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Area</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Dibuat oleh</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr class="border-t">
                        <td class="p-3">{{ $task->title }}</td>
                        <td class="p-3">{{ $task->department?->name }}</td>
                        <td class="p-3">{{ $task->area?->name }}</td>
                        <td class="p-3">{{ $task->due_date?->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $task->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="p-3">{{ $task->creator?->name }}</td>
                        <td class="flex gap-2 p-3">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Hapus task ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tasks->links() }}</div>
@endsection