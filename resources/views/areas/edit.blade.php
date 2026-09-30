@extends('layouts.app')
@section('title', 'Edit Area')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Edit Area</h1>
    <form method="POST" action="{{ route('areas.update', $area) }}" class="rounded bg-white p-4 shadow">
        @method('PUT')
        @include('areas._form')
    </form>
@endsection