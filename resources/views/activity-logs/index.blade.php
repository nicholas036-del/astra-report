@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('content')
    <h1 class="mb-4 text-2xl font-bold">Log Aktivitas</h1>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-sm">
            <thead class="border-b bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Waktu</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b">
                        <td class="p-3">{{ optional($log->created_at)->format('d M Y H:i') ?? '-' }}</td>
                        <td class="p-3">{{ $log->user->name ?? '-' }}</td>
                        <td class="p-3">{{ $log->description ?? $log->action ?? $log->activity ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-3 text-gray-500">Belum ada log.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $logs->links() }}</div>
@endsection