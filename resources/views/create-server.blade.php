@extends('layouts.app')

@section('title', 'Add New Server')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Add New Server</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servers.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-lg">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Server Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="ip_address" class="block font-semibold mb-1">IP Address</label>
            <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}"
                   class="w-full border border-gray-300 p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Description</label>
            <textarea name="description" id="description"
                      class="w-full border border-gray-300 p-2 rounded">{{ old('description') }}</textarea>
        </div>

        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Add Server
        </button>
    </form>
@endsection
