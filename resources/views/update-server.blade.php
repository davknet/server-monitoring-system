@extends('layouts.app')

@section('title', 'Update Server')

@section('content')

<div class="min-h-screen bg-gray-100 py-10 px-4">

    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">
        Update Server
    </h1>



    <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">
            <form action="{{ route('servers.search') }}" method="GET" class="mb-6 flex flex-col md:flex-row gap-2">

    <input type="text"
           name="query"
           placeholder="Search by  Name, IP, Port, Method..."
           value="{{ request('query') }}"
           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">

    <button type="submit"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
        Search
    </button>

    <a href="{{ route('update-server') }}"
       class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition text-center">
        Reset
    </a>

</form>
            <table class="min-w-full text-sm text-left">

                <!-- Table Head -->
                <thead class="bg-gray-800 text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4">Port</th>
                        <th class="px-6 py-4">Method</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200">

                    @forelse($servers as $server)
                        <tr class="hover:bg-gray-50 transition duration-200 even:bg-gray-50">

                            <td class="px-6 py-4 font-semibold text-gray-700">
                                {{ $server->id }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $server->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $server->ip_address ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $server->port ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $server->method ?? '—' }}
                            </td>

                             <td class="px-6 py-4">
                                {{ $server->description ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $server->created_at->format('Y-m-d') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-center space-x-2">

                                <!-- Update Button -->
                                <a href="{{ route('servers.edit', $server->id) }}"
                                   class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition">
                                    Update
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('servers.destroy', $server ) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                No servers found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
