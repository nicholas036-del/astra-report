@extends('layouts.app')
@section('title', 'Kirim Laporan')

@section('content')
    <h1 class="mb-1 text-xl font-bold">Kirim Laporan</h1>
    <p class="mb-4 text-sm text-gray-600">Task: {{ $task->title }}</p>

    <form method="POST" action="{{ route('submissions.store', $task) }}" enctype="multipart/form-data"
          class="rounded bg-white p-4 shadow">
        @include('submissions._form')
    </form>
@endsection