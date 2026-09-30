@extends('layouts.app')
@section('title', 'Edit Dealer')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Edit Dealer</h1>
    <form method="POST" action="{{ route('dealers.update', $dealer) }}" class="rounded bg-white p-4 shadow">
        @method('PUT')
        @include('dealers._form')
    </form>
@endsection