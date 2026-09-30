@extends('layouts.app')
@section('title', 'Tambah Dealer')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Tambah Dealer</h1>
    <form method="POST" action="{{ route('dealers.store') }}" class="rounded bg-white p-4 shadow">
        @include('dealers._form')
    </form>
@endsection