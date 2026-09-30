@extends('layouts.app')
@section('title', 'Review Laporan')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-bold">Review Laporan</h1>
        <form method="GET" action="{{ route('reviews.index') }}">
            <select name="status" onchange="this.form.submit()" class="rounded border p-2 text-sm">
                @foreach (['MENUNGGU', 'DISETUJUI', 'REVISI', 'DITOLAK', 'SEMUA'] as $option)
                    <option value="{{ $option }}" @selected($status === $option)>{{ $option }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Dealer</th>
                    <th class="p-3">Task</th>
                    <th class="p-3">Dikirim</th>
                    <th class="p-3">Kirim ulang</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $submission)
                    <tr class="border-t">
                        <td class="p-3">{{ $submission->dealer?->name }}</td>
                        <td class="p-3">{{ $submission->task?->title }}</td>
                        <td class="p-3">{{ $submission->submitted_at?->format('d/m/Y H:i') }}</td>
                        <td class="p-3">{{ $submission->resubmit_count }}x</td>
                        <td class="p-3">{{ $submission->status }}</td>
                        <td class="p-3">
                            <a href="{{ route('reviews.show', $submission) }}" class="text-blue-600">
                                {{ $submission->status === 'MENUNGGU' ? 'Review' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center text-gray-500">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
@endsection