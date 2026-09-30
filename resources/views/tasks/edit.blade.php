@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Edit Task</h1>
    <form method="POST" action="{{ route('tasks.update', $task) }}" class="rounded bg-white p-4 shadow">
        @method('PUT')
        @include('tasks._form')
    </form>
@endsection