@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
    <a href="{{ route('reviews.index') }}" class="text-sm text-blue-600">&larr; Kembali</a>
    <h1 class="mb-4 mt-2 text-xl font-bold">Detail Laporan</h1>

    <div class="mb-4 rounded bg-white p-4 text-sm shadow">
        <dl class="grid grid-cols-3 gap-2">
            <dt class="font-medium">Dealer</dt>
            <dd class="col-span-2">{{ $submission->dealer?->name }}</dd>

            <dt class="font-medium">Task</dt>
            <dd class="col-span-2">{{ $submission->task?->title }}</dd>

            <dt class="font-medium">Department / Area</dt>
            <dd class="col-span-2">{{ $submission->task?->department?->name }} / {{ $submission->task?->area?->name }}</dd>

            <dt class="font-medium">Dikirim oleh</dt>
            <dd class="col-span-2">{{ $submission->submitter?->name }} ({{ $submission->submitted_at?->format('d/m/Y H:i') }})</dd>

            <dt class="font-medium">Kirim ulang</dt>
            <dd class="col-span-2">{{ $submission->resubmit_count }}x</dd>

            <dt class="font-medium">Status</dt>
            <dd class="col-span-2">{{ $submission->status }}</dd>

            <dt class="font-medium">Isi laporan</dt>
            <dd class="col-span-2 whitespace-pre-line">{{ $submission->content }}</dd>

            <dt class="font-medium">Lampiran</dt>
            <dd class="col-span-2">
                @if ($submission->file_path)
                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600">Lihat file</a>
                @else
                    -
                @endif
            </dd>

            @if ($submission->reviewed_at)
                <dt class="font-medium">Direview oleh</dt>
                <dd class="col-span-2">{{ $submission->reviewer?->name }} ({{ $submission->reviewed_at->format('d/m/Y H:i') }})</dd>

                <dt class="font-medium">Catatan</dt>
                <dd class="col-span-2 whitespace-pre-line">{{ $submission->reviewer_note ?? '-' }}</dd>
            @endif
        </dl>
    </div>

    @if ($submission->status === 'MENUNGGU')
        <form method="POST" action="{{ route('reviews.update', $submission) }}" class="rounded bg-white p-4 shadow">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block text-sm font-medium">Keputusan</label>
                <select name="status" class="w-full rounded border p-2">
                    <option value="">- Pilih -</option>
                    @foreach (['DISETUJUI', 'REVISI', 'DITOLAK'] as $option)
                        <option value="{{ $option }}" @selected(old('status') === $option)>{{ $option }}</option>
                    @endforeach
                </select>
                @error('status') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Catatan (wajib untuk REVISI dan DITOLAK)</label>
                <textarea name="reviewer_note" rows="4" class="w-full rounded border p-2">{{ old('reviewer_note') }}</textarea>
                @error('reviewer_note') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan review</button>
        </form>
    @endif
@endsection