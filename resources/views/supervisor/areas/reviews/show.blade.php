@extends('layouts.app')
@section('title', 'Periksa Tugas')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Periksa Pengumpulan Tugas</h1>

    <div class="bg-white p-6 rounded shadow max-w-2xl space-y-2 mb-6">
        <p><span class="font-medium">Nama Laporan:</span> {{ $submission->task->title }}</p>
        <p><span class="font-medium">Nama Dealer:</span> {{ $submission->dealer->name }}</p>
        <p><span class="font-medium">Departemen / Area:</span> {{ $submission->task->department->name }} / {{ $submission->task->area->name }}</p>
        <p><span class="font-medium">Tanggal Kumpul:</span> {{ $submission->submitted_at?->format('d-m-Y H:i') }}</p>
        <p>
            <span class="font-medium">Link Google Drive:</span>
            <a href="{{ $submission->google_drive_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $submission->google_drive_link }}</a>
        </p>
        @if ($submission->dealer_note)
            <p><span class="font-medium">Catatan Dealer:</span> {{ $submission->dealer_note }}</p>
        @endif
    </div>

    <form method="POST" action="{{ route('supervisor.reviews.update', $submission) }}" class="bg-white p-6 rounded shadow max-w-2xl space-y-4 mb-6">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Status Pengumpulan</label>
            <select name="status" class="w-full rounded border-gray-300">
                <option value="REVISI" @selected($submission->status === 'REVISI')>REVISI</option>
                <option value="DISETUJUI" @selected($submission->status === 'DISETUJUI')>DISETUJUI</option>
                <option value="DITOLAK" @selected($submission->status === 'DITOLAK')>DITOLAK</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Catatan Supervisor (opsional)</label>
            <textarea name="supervisor_note" rows="3" class="w-full rounded border-gray-300">{{ old('supervisor_note', $submission->supervisor_note) }}</textarea>
        </div>
        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Simpan Hasil Pemeriksaan</button>
    </form>

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
                @forelse ($submission->logs as $log)
                    <tr>
                        <td class="px-4 py-2">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $log->activity }}</td>
                        <td class="px-4 py-2">{{ $log->note ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('supervisor.reviews.index') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">&larr; Kembali</a>
@endsection
