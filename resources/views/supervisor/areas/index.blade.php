@extends('layouts.app')
@section('title', 'Review')
@section('content')
    <h1 class="mb-4 text-2xl font-bold">Review</h1>

    <div class="overflow-x-auto rounded bg-white shadow">
        <table class="w-full text-sm">
            <thead class="border-b bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Dealer</th>
                    <th class="p-3">Task</th>
                    <th class="p-3">Status</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $s)
                    <tr class="border-b">
                        <td class="p-3">{{ $s->dealer->name ?? '-' }}</td>
                        <td class="p-3">{{ $s->task->title ?? $s->task->name ?? '-' }}</td>
                        <td class="p-3">{{ $s->status ?? '-' }}</td>
                        <td class="p-3">
                            <a href="{{ route('reviews.show', $s) }}" class="text-blue-600 hover:underline">Periksa</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-3 text-gray-500">Belum ada pengumpulan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($submissions, 'links'))
        <div class="mt-4">{{ $submissions->links() }}</div>
    @endif
@endsection