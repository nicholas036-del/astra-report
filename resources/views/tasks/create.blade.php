@extends('layouts.app')
@section('title', 'Tambah Task')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Tambah Task</h1>
    <form method="POST" action="{{ route('tasks.store') }}" class="rounded bg-white p-4 shadow">
        @include('tasks._form')
    </form>
@endsection