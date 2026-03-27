@extends('layouts.app')

@section('title', 'home')

@section('content')
    <h1 class="text-4xl font-bold text-center mb-8">Dashboard</h1>
    <p class="text-center text-lg mb-4">.</p>
    <div class="flex justify-center">

        <a href="/servers" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">View Servers</a>
    </div>
@endsection
