@extends('layouts.app')
@section('title', 'Tambah Department')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Tambah Department</h1>
    <form method="POST" action="{{ route('departments.store') }}" class="rounded bg-white p-4 shadow">
        @include('departments._form')
    </form>
@endsection