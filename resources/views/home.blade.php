@extends('layouts.app')

@section('title', 'Server Health Checks')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Server Health Checks</h1>

<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg shadow-lg" id="decision">
        <thead class="bg-gradient-to-r from-blue-200 to-blue-100 text-gray-700">
            <tr class="uppercase text-sm tracking-wider">
                <th class="p-3 border-b">Server Name</th>
                <th class="p-3 border-b">IP Address</th>
                <th class="p-3 border-b">Status</th>
                <th class="p-3 border-b">Timestamp</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <!-- rows populated via JS -->
        </tbody>
    </table>
</div>

<!-- Pagination Controls -->
<div class="mt-4 flex justify-center space-x-2" id="pagination"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#decision tbody');
    const paginationDiv = document.getElementById('pagination');

    let currentPage = 1;

    function fetchServerTests(page = 1) {
        fetch('http://127.0.0.1:8000/tests?page=' + page)
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';
                paginationDiv.innerHTML = '';

                const tests = data.data;

                if (!tests || tests.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center p-4 text-gray-500">No server tests found</td></tr>';
                    return;
                }

                // populate table
                tests.forEach((test, index) => {
                    const row = document.createElement('tr');
                    const bgClass = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                    const statusClass = test.status === 'healthy'
                        ? 'bg-green-100 text-green-800 font-semibold px-2 py-1 rounded-full text-center'
                        : 'bg-red-100 text-red-800 font-semibold px-2 py-1 rounded-full text-center';

                    row.className = `${bgClass} hover:bg-blue-50 transition`;
                    row.innerHTML = `
                        <td class="p-3 border-b text-gray-700">${test.name}</td>
                        <td class="p-3 border-b text-gray-700">${test.ip_address}</td>
                        <td class="p-3 border-b"><span class="${statusClass}">${test.status}</span></td>
                        <td class="p-3 border-b text-gray-500">${test.timestamp ?? '-'}</td>
                    `;
                    tableBody.appendChild(row);
                });

                // Pagination (max 6 buttons)
                const totalPages = data.last_page || 1;
                const current = data.current_page || 1;

                let start = Math.max(1, current - 2);
                let end = Math.min(totalPages, start + 5);

                if (end - start < 5) start = Math.max(1, end - 5);

                // Prev button
                if (data.prev_page_url) {
                    const prevBtn = document.createElement('button');
                    prevBtn.textContent = 'Prev';
                    prevBtn.className = 'px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 transition';
                    prevBtn.onclick = () => {
                        currentPage--;
                        fetchServerTests(currentPage);
                    };
                    paginationDiv.appendChild(prevBtn);
                }

                // Page numbers
                for (let i = start; i <= end; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.className = `px-3 py-1 rounded ${
                        i === current
                            ? 'bg-blue-500 text-white'
                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300 transition'
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
                    nextBtn.className = 'px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 transition';
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
