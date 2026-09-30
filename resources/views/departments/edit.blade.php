@extends('layouts.app')
@section('title', 'Edit Department')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Edit Department</h1>
    <form method="POST" action="{{ route('departments.update', $department) }}" class="rounded bg-white p-4 shadow">
        @method('PUT')
        @include('departments._form')
    </form>
@endsection