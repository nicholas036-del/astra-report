@extends('layouts.app')
@section('title', 'Task')
@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Task</h1>
        @if (Route::has('tasks.create'))
            <a href="{{ route('tasks.create') }}"
               class="rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">Tambah Task</a>
        @endif
    </div>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-sm">
            <thead class="border-b bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr class="border-b">
                        <td class="p-3">{{ $task->title ?? $task->name ?? '-' }}</td>
                        <td class="p-3">{{ ($task->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="p-3 text-gray-500">Belum ada task.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($tasks, 'links'))
        <div class="mt-4">{{ $tasks->links() }}</div>
    @endif
@endsection