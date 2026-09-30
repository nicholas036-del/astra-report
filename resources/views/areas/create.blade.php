@extends('layouts.app')
@section('title', 'Tambah Area')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Tambah Area</h1>
    <form method="POST" action="{{ route('areas.store') }}" class="rounded bg-white p-4 shadow">
        @include('areas._form')
    </form>
@endsection