@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="mb-4">
    <h1 class="text-xl font-bold">Daftar Log Aktivitas</h1>
</div>

<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Waktu</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Aktivitas / Deskripsi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($logs as $log)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ $log->created_at->format('d-m-Y H:i:s') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                        {{ $log->user->name ?? 'Sistem / Tamu' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $log->description ?? $log->action ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data log aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>
@endsection