@extends('layouts.app')

@section('title', 'Add New Server')

@section('content')

<h1 class="text-3xl font-bold mb-6">Demo Connection </h1>

<div class="bg-red-100 text-red-700 p-4 mb-4 rounded">

    <p>url : {{ $url }}</p>
    <p>Status: {{ $success  }}</p>
    <p>Message: {{ $message }}</p>
</div>
@endsection
