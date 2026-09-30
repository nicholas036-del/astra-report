@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Tambah User</h1>
    <form method="POST" action="{{ route('users.store') }}" class="rounded bg-white p-4 shadow">
        @include('users._form')
    </form>
@endsection