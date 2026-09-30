@extends('layouts.app')
@section('title', 'Laporan Saya')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Task &amp; Laporan Saya</h1>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Task</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Area</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Catatan</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    @php $submission = $task->submissions->first(); @endphp
                    <tr class="border-t">
                        <td class="p-3">{{ $task->title }}</td>
                        <td class="p-3">{{ $task->department?->name }}</td>
                        <td class="p-3">{{ $task->area?->name }}</td>
                        <td class="p-3">{{ $task->due_date?->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $submission?->status ?? 'BELUM DIKIRIM' }}</td>
                        <td class="p-3">{{ $submission?->reviewer_note }}</td>
                        <td class="p-3">
                            @if (! $submission)
                                <a href="{{ route('submissions.create', $task) }}" class="text-blue-600">Kirim</a>
                            @elseif ($submission->canResubmit())
                                <a href="{{ route('submissions.edit', $submission) }}" class="text-blue-600">Kirim ulang</a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-500">Belum ada task aktif.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tasks->links() }}</div>
@endsection