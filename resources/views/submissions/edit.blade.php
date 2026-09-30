@extends('layouts.app')
@section('title', 'Kirim Ulang Laporan')

@section('content')
    <h1 class="mb-1 text-xl font-bold">Kirim Ulang Laporan</h1>
    <p class="mb-2 text-sm text-gray-600">Task: {{ $submission->task->title }}</p>

    @if ($submission->reviewer_note)
        <div class="mb-4 rounded bg-yellow-100 p-3 text-sm text-yellow-800">
            Catatan revisi: {{ $submission->reviewer_note }}
        </div>
    @endif

    <form method="POST" action="{{ route('submissions.update', $submission) }}" enctype="multipart/form-data"
          class="rounded bg-white p-4 shadow">
        @method('PUT')
        @include('submissions._form')
    </form>
@endsection