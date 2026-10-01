@extends('layouts.app')
@section('title', 'Periksa Tugas')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-bold">Review Laporan</h1>
        <a href="{{ route('reviews.export', request()->query()) }}"
           class="rounded bg-green-600 px-4 py-2 text-sm text-white">Export Excel (CSV)</a>
    </div>

    <form method="GET" action="{{ route('reviews.index') }}"
          class="mb-4 grid grid-cols-1 gap-2 rounded bg-white p-4 shadow md:grid-cols-5">
        <select name="status" class="rounded border p-2 text-sm">
            @foreach (['MENUNGGU', 'DISETUJUI', 'REVISI', 'DITOLAK', 'SEMUA'] as $option)
                <option value="{{ $option }}" @selected($status === $option)>{{ $option }}</option>
            @endforeach
        </select>

        <select name="dealer_id" class="rounded border p-2 text-sm">
            <option value="">Semua dealer</option>
            @foreach ($dealers as $dealer)
                <option value="{{ $dealer->id }}" @selected($dealerId == $dealer->id)>{{ $dealer->name }}</option>
            @endforeach
        </select>

        <select name="task_id" class="rounded border p-2 text-sm">
            <option value="">Semua task</option>
            @foreach ($tasks as $task)
                <option value="{{ $task->id }}" @selected($taskId == $task->id)>{{ $task->title }}</option>
            @endforeach
        </select>

        <input type="text" name="q" value="{{ $search }}" placeholder="Cari isi laporan"
               class="rounded border p-2 text-sm">

        <div class="flex gap-2">
            <button class="rounded bg-blue-600 px-4 py-2 text-sm text-white">Filter</button>
            <a href="{{ route('reviews.index') }}" class="rounded border px-4 py-2 text-sm">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded bg-white shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-2">Nama Laporan</th>
                    <th class="px-4 py-2">Dealer</th>
                    <th class="px-4 py-2">Tanggal Kumpul</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($submissions as $submission)
                    <tr>
                        <td class="px-4 py-2">{{ $submission->task?->title }}</td>
                        <td class="px-4 py-2">{{ $submission->dealer?->name }}</td>
                        <td class="px-4 py-2">{{ $submission->submitted_at?->format('d-m-Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <span @class([
                                'rounded px-2 py-1 text-xs font-medium',
                                'bg-gray-100 text-gray-800' => $submission->status === 'MENUNGGU',
                                'bg-yellow-100 text-yellow-800' => $submission->status === 'REVISI',
                                'bg-green-100 text-green-800' => $submission->status === 'DISETUJUI',
                                'bg-red-100 text-red-800' => $submission->status === 'DITOLAK',
                            ])>{{ $submission->status }}</span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('reviews.show', $submission) }}" class="text-blue-600 hover:underline">
                                {{ $submission->status === 'MENUNGGU' ? 'Periksa' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada tugas yang dikumpulkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
@endsection