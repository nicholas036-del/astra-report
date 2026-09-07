@extends('layouts.app')
@section('title', 'Periksa Tugas')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Pemeriksaan Tugas Dealer</h1>

    <div class="bg-white rounded shadow overflow-hidden">
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
                        <td class="px-4 py-2">{{ $submission->task->title }}</td>
                        <td class="px-4 py-2">{{ $submission->dealer->name }}</td>
                        <td class="px-4 py-2">{{ $submission->submitted_at?->format('d-m-Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <span @class([
                                'px-2 py-1 rounded text-xs font-medium',
                                'bg-yellow-100 text-yellow-800' => $submission->status === 'REVISI',
                                'bg-green-100 text-green-800' => $submission->status === 'DISETUJUI',
                                'bg-red-100 text-red-800' => $submission->status === 'DITOLAK',
                            ])>{{ $submission->status }}</span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('supervisor.reviews.show', $submission) }}" class="text-blue-600 hover:underline">Periksa</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada tugas yang dikumpulkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
@endsection
