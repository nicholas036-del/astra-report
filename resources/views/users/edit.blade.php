@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user) }}" class="rounded bg-white p-4 shadow">
        @method('PUT')
        @include('users._form')
    </form>
@endsection