@extends('layouts.app')
@section('title', 'Daftar Tugas')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Daftar Tugas</h1>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-2">Nama Laporan</th>
                    <th class="px-4 py-2">Departemen</th>
                    <th class="px-4 py-2">Area</th>
                    <th class="px-4 py-2">Batas Waktu</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($tasks as $task)
                    @php $submission = $task->submissions->first(); @endphp
                    <tr>
                        <td class="px-4 py-2">{{ $task->title }}</td>
                        <td class="px-4 py-2">{{ $task->department->name }}</td>
                        <td class="px-4 py-2">{{ $task->area->name }}</td>
                        <td class="px-4 py-2">{{ $task->due_at->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">
                            @if ($submission)
                                <span @class([
                                    'px-2 py-1 rounded text-xs font-medium',
                                    'bg-yellow-100 text-yellow-800' => $submission->status === 'REVISI',
                                    'bg-green-100 text-green-800' => $submission->status === 'DISETUJUI',
                                    'bg-red-100 text-red-800' => $submission->status === 'DITOLAK',
                                ])>{{ $submission->status }}</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">Belum Dikumpulkan</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('dealer.tasks.show', $task) }}" class="text-blue-600 hover:underline">Detail</a>
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
