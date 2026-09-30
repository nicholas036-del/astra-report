@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-1 text-xl font-bold">Dashboard</h1>
    <p class="mb-4 text-sm text-gray-600">
        Selamat datang, {{ auth()->user()->name }} ({{ auth()->user()->role }})
    </p>

    @php
        $colors = [
            'MENUNGGU' => 'text-yellow-600',
            'DISETUJUI' => 'text-green-600',
            'REVISI' => 'text-orange-600',
            'DITOLAK' => 'text-red-600',
        ];
    @endphp

    <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
        @foreach ($stats as $status => $total)
            <div class="rounded bg-white p-4 shadow">
                <p class="text-sm text-gray-500">{{ $status }}</p>
                <p class="text-3xl font-bold {{ $colors[$status] }}">{{ $total }}</p>
            </div>
        @endforeach
    </div>

    <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="rounded bg-white p-4 shadow">
            <p class="text-sm text-gray-500">Task aktif</p>
            <p class="text-2xl font-bold">{{ $activeTasks }}</p>
        </div>

        @if (auth()->user()->isDealer())
            <div class="rounded bg-white p-4 shadow">
                <p class="text-sm text-gray-500">Belum dikirim</p>
                <p class="text-2xl font-bold">{{ $notSubmitted }}</p>
            </div>
        @endif

        @if (! is_null($dealerCount))
            <div class="rounded bg-white p-4 shadow">
                <p class="text-sm text-gray-500">Dealer</p>
                <p class="text-2xl font-bold">{{ $dealerCount }}</p>
            </div>
        @endif
    </div>

    @if (auth()->user()->isDealer())
        <a href="{{ route('submissions.index') }}" class="inline-block rounded bg-blue-600 px-4 py-2 text-white">
            Buka Laporan Saya
        </a>
    @else
        <div class="rounded bg-white p-4 shadow">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="font-bold">Menunggu review</h2>
                <a href="{{ route('reviews.index') }}" class="text-sm text-blue-600">Lihat semua</a>
            </div>

            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2">Dealer</th>
                        <th class="p-2">Task</th>
                        <th class="p-2">Dikirim</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pending as $submission)
                        <tr class="border-t">
                            <td class="p-2">{{ $submission->dealer?->name }}</td>
                            <td class="p-2">{{ $submission->task?->title }}</td>
                            <td class="p-2">{{ $submission->submitted_at?->format('d/m/Y H:i') }}</td>
                            <td class="p-2">
                                <a href="{{ route('reviews.show', $submission) }}" class="text-blue-600">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-2 text-center text-gray-500">Tidak ada laporan yang menunggu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection