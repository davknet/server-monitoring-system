@extends('layouts.app')

@section('title', 'Server Health Checks')

@section('content')
<h1 class="text-3xl font-bold mb-6">Server Health Checks</h1>

<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300 rounded-lg shadow-md" id="servers-table">
        <thead class="bg-gray-200">
            <tr class="text-left">
                <th class="p-3 border-b">Server Name</th>
                <th class="p-3 border-b">IP Address</th>
                <th class="p-3 border-b">Status</th>
                <th class="p-3 border-b">Message</th>
                <th class="p-3 border-b">Tested At</th>
            </tr>
        </thead>
        <tbody>
            <!-- rows populated via JS -->
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#servers-table tbody');

    function fetchServerTests() {
        fetch('{{ route("server-tests") }}')
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = ''; // clear old rows

                data.forEach((test, index) => {
                    const row = document.createElement('tr');

                    // alternating row colors
                    const bgClass = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';

                    // status color
                    const statusClass = test.status === 'healthy'
                        ? 'text-green-700 font-semibold'
                        : 'text-red-700 font-semibold';

                    row.className = `${bgClass} hover:bg-gray-100 transition`;

                    row.innerHTML = `
                        <td class="p-3 border-b">${test.server_name}</td>
                        <td class="p-3 border-b">${test.server_ip}</td>
                        <td class="p-3 border-b ${statusClass}">${test.status}</td>
                        <td class="p-3 border-b">${test.message ?? '-'}</td>
                        <td class="p-3 border-b">${test.tested_at}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(err => console.error('Error fetching server tests:', err));
    }

    // Fetch initially
    fetchServerTests();

    // Fetch every 10 seconds
    setInterval(fetchServerTests, 10000);
});
</script>
@endsection
