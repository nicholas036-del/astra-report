@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="text-2xl font-bold mb-2">Dashboard</h1>
    <p class="mb-6">Selamat datang, {{ auth()->user()->name }}.</p>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @isset($activeTasks)
            <div class="bg-white rounded shadow p-4">
                <div class="text-sm text-gray-500">Tugas Aktif</div>
                <div class="text-2xl font-bold">{{ $activeTasks }}</div>
            </div>
        @endisset

        @isset($dealerCount)
            <div class="bg-white rounded shadow p-4">
                <div class="text-sm text-gray-500">Jumlah Dealer</div>
                <div class="text-2xl font-bold">{{ $dealerCount }}</div>
            </div>
        @endisset

        @isset($notSubmitted)
            <div class="bg-white rounded shadow p-4">
                <div class="text-sm text-gray-500">Belum Dikumpulkan</div>
                <div class="text-2xl font-bold">{{ $notSubmitted }}</div>
            </div>
        @endisset
    </div>

    {{-- Jumlah pengumpulan per status --}}
    @if (!empty($counts))
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @foreach ($counts as $status => $total)
                <div class="bg-white rounded shadow p-4">
                    <div class="text-sm text-gray-500">{{ $status }}</div>
                    <div class="text-2xl font-bold">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Menunggu pemeriksaan (supervisor) --}}
    @if (isset($pending) && $pending->count())
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Menunggu Pemeriksaan</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Dealer</th>
                        <th class="py-2">Tugas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pending as $s)
                        <tr class="border-b">
                            <td class="py-2">{{ $s->dealer->name ?? '-' }}</td>
                            <td class="py-2">{{ $s->task->title ?? $s->task->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection