<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table with Filters and Search</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e8dfec;
        }
        .filter-container {
            margin-bottom: 20px;
        }
        .search-bar {
            margin-left: auto;
            max-width: 300px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Data Table</h1>

        <div class="row">
            <div class="col-md-6">
                <!-- Filters and Search Bar -->
                <div class="filter-container d-flex align-items-center mb-4">
                    <div class="me-3">
                        <label for="monthFilter" class="form-label">Month:</label>
                        <select id="monthFilter" class="form-select">
                            <option value="">All</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <label for="yearFilter" class="form-label">Year:</label>
                        <select id="yearFilter" class="form-select">
                            <option value="">All</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <label for="trackFilter" class="form-label">Track/Strand:</label>
                        <select id="trackFilter" class="form-select">
                            <option value="">All</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <form id="search-form" class="d-flex w-100">
                        <div class="input-group">
                            <input class="form-control rounded-pill" type="search" id="query" placeholder="Search" aria-label="Search" autocomplete='off'>
                            <span class="btn rounded-pill" type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Month Year</th>
                    <th>Track/Strand</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be dynamically generated here -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Separate JS File for Populating Filters -->
    <script src="fetchFilters.js"></script>

    <!-- Existing Script for Fetching Data and Handling Events -->
    <script>
        const searchBar = document.getElementById('query');
        const dataTable = document.getElementById('dataTable').getElementsByTagName('tbody')[0];

        async function fetchData() {
            const query = searchBar.value.trim();
            const month = monthFilter.value;
            const year = yearFilter.value;
            const track = trackFilter.value;

            const url = '../../backend/searchfetch.php?' + new URLSearchParams({
                query: query,
                record_type: 'record',
                month: month,
                year: year,
                track: track
            });

            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                // Convert month numbers to names
                data.forEach(item => {
                    item.record_month = getMonthName(item.record_month);
                });
                renderTable(data);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        function renderTable(data) {
            dataTable.innerHTML = '';
            if (data.length > 0) {
                data.forEach(item => {
                    const row = dataTable.insertRow();
                    row.insertCell(0).textContent = item.record_title;
                    row.insertCell(1).textContent = item.record_month + ' ' + item.record_year;
                    row.insertCell(2).textContent = item.record_trackstrand;
                });
            } else {
                const row = dataTable.insertRow();
                const cell = row.insertCell(0);
                cell.colSpan = 3;
                cell.textContent = 'No records found';
                cell.classList.add('text-center');
            }
        }

        // Fetch data when the filters change
        monthFilter.addEventListener('change', fetchData);
        yearFilter.addEventListener('change', fetchData);
        trackFilter.addEventListener('change', fetchData);
        searchBar.addEventListener('input', fetchData);

        fetchData(); // Initial data fetch
    </script>
</body>
</html>
