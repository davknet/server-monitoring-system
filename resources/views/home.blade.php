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

<!-- Pagination Controls -->
<div class="mt-4 flex justify-center space-x-1" id="pagination"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#servers-table tbody');
    const paginationDiv = document.getElementById('pagination');

    let currentPage = 1;

    function fetchServerTests(page = 1) {
        fetch('http://127.0.0.1:8000/server-tests?page=' + page)
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';
                paginationDiv.innerHTML = '';

                const tests = data.data;

                if (tests.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center p-3">No server tests found</td></tr>';
                    return;
                }

                // populate table
                tests.forEach((test, index) => {
                    const row = document.createElement('tr');
                    const bgClass = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
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

                // Smart pagination (max 6 buttons)
const totalPages = data.last_page;
const current = data.current_page;

let start = Math.max(1, current - 2);
let end = Math.min(totalPages, start + 5);

// fix range near the end
if (end - start < 5) {
    start = Math.max(1, end - 5);
}

// Prev button
if (data.prev_page_url) {
    const prevBtn = document.createElement('button');
    prevBtn.textContent = 'Prev';
    prevBtn.className = 'px-3 py-1 bg-gray-300 rounded hover:bg-gray-400';
    prevBtn.onclick = () => {
        currentPage--;
        fetchServerTests(currentPage);
    };
    paginationDiv.appendChild(prevBtn);
}

// Page numbers (max 6)
for (let i = start; i <= end; i++) {
    const btn = document.createElement('button');
    btn.textContent = i;

    btn.className = `px-3 py-1 rounded ${
        i === current
            ? 'bg-blue-500 text-white'
            : 'bg-gray-300 text-gray-700 hover:bg-gray-400'
    }`;

    btn.onclick = () => {
        currentPage = i;
        fetchServerTests(i);
    };

    paginationDiv.appendChild(btn);
}

// Next button
if (data.next_page_url) {
    const nextBtn = document.createElement('button');
    nextBtn.textContent = 'Next';
    nextBtn.className = 'px-3 py-1 bg-gray-300 rounded hover:bg-gray-400';
    nextBtn.onclick = () => {
        currentPage++;
        fetchServerTests(currentPage);
    };
    paginationDiv.appendChild(nextBtn);
}
            })
            .catch(err => console.error('Error fetching server tests:', err));
    }

    fetchServerTests();
    setInterval(() => fetchServerTests(currentPage), 10000);
});
</script>
@endsection
