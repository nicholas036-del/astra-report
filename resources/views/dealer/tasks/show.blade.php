@extends('layouts.app')
@section('title', 'Detail Tugas')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Detail Tugas</h1>

    <div class="bg-white p-6 rounded shadow max-w-2xl space-y-2 mb-6">
        <p><span class="font-medium">Nama Laporan:</span> {{ $task->title }}</p>
        <p><span class="font-medium">Departemen:</span> {{ $task->department->name }}</p>
        <p><span class="font-medium">Area:</span> {{ $task->area->name }}</p>
        <p><span class="font-medium">Deadline:</span> {{ $task->due_at->format('d-m-Y') }}
            @if ($task->isPastDue())
                <span class="text-red-600 text-xs font-medium">(Sudah lewat batas waktu)</span>
            @endif
        </p>
    </div>

    @if (! $submission || $submission->canBeResubmitted())
        <form method="POST" action="{{ route('dealer.submissions.store', $task) }}" class="bg-white p-6 rounded shadow max-w-2xl space-y-4 mb-6">
            @csrf
            <h2 class="text-md font-semibold">{{ $submission ? 'Kumpulkan Ulang Tugas' : 'Kumpulkan Tugas' }}</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Link Google Drive</label>
                <input type="url" name="google_drive_link" value="{{ old('google_drive_link', $submission->google_drive_link ?? '') }}"
                    placeholder="https://drive.google.com/..." class="w-full rounded border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Catatan (opsional)</label>
                <textarea name="dealer_note" rows="3" class="w-full rounded border-gray-300">{{ old('dealer_note') }}</textarea>
            </div>
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Kumpulkan</button>
        </form>
    @elseif ($submission)
        <div class="bg-white p-6 rounded shadow max-w-2xl mb-6 text-sm text-gray-600">
            Tugas ini berstatus <span class="font-medium">{{ $submission->status }}</span> dan tidak dapat dikumpulkan ulang.
        </div>
    @endif

    @if ($submission)
        <h2 class="text-md font-semibold mb-2">Riwayat Aktivitas</h2>
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Aktivitas</th>
                        <th class="px-4 py-2">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($submission->logs as $log)
                        <tr>
                            <td class="px-4 py-2">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $log->activity }}</td>
                            <td class="px-4 py-2">{{ $log->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('dealer.tasks.index') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">&larr; Kembali</a>
@endsection
