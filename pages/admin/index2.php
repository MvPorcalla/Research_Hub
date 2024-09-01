<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table with Filters and Search</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <h1 class="mt-4 my-4">Data Table</h1>

        <div class="row">
            <div class="col-md-6">
                <!-- Filters and Search Bar -->
                <div class="filter-container d-flex align-items-center mb-4">
                    <div class="me-3">
                        <select id="monthFilter" class="form-select">
                            <option value="">All Month</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <select id="yearFilter" class="form-select">
                            <option value="">All Year</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <select id="trackFilter" class="form-select">
                            <option value="">All Strand</option>
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
                    <th>Author</th>
                    <th>Track/Strand</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="abstractTiles">
                <!-- Table rows will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- Custom JS -->
    <script src="fetchFilters.js"></script> <!-- Include the external JavaScript file -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('search-form');
            const queryInput = document.getElementById('query');

            // Function to fetch and display data
            function fetchData() {
                const query = queryInput.value.trim();
                const month = document.getElementById('monthFilter').value;
                const year = document.getElementById('yearFilter').value;
                const track = document.getElementById('trackFilter').value;

                fetch(`../../backend/searchfetch.php?query=${encodeURIComponent(query)}&month=${encodeURIComponent(month)}&year=${encodeURIComponent(year)}&track=${encodeURIComponent(track)}&record_type=record`)
                    .then(response => response.json())
                    .then(data => populateTable(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Function to highlight search query in table
            function highlightText(text, query) {
                if (!query) return text;
                const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp('(' + escapedQuery + ')', 'gi');
                return text.replace(regex, '<strong>$1</strong>');
            }

            // Function to populate the table
            function populateTable(data) {
                const tableBody = document.getElementById('abstractTiles');
                tableBody.innerHTML = ''; // Clear existing rows

                let rows = '';

                data.forEach(record => {
                    const month = new Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, record.record_month - 1));
                    
                    rows += `
                        <tr onclick="if (!event.target.closest('a')) { window.location.href='abstractView.php?abstractId=${record.record_id}'; }" style="cursor: pointer;">
                            <td>${highlightText(record.record_title, queryInput.value)}</td>
                            <td>${month + ' ' + record.record_year}</td>
                            <td>${highlightText(record.record_authors, queryInput.value)}</td>
                            <td>${record.record_trackstrand}</td>
                            <td>
                                <a href="abstract.php?abstractId=${record.record_id}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                <a href="../../backend/delete.php?abstractId=${record.record_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                            </td>
                        </tr>
                    `;
                });

                tableBody.innerHTML = rows;
            }

            // Event listener for form submit
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                fetchData();
            });

            // Event listeners for filter changes
            document.getElementById('monthFilter').addEventListener('change', fetchData);
            document.getElementById('yearFilter').addEventListener('change', fetchData);
            document.getElementById('trackFilter').addEventListener('change', fetchData);

            // Event listener for query input change
            queryInput.addEventListener('input', fetchData);

            // Fetch data on page load
            fetchData();
        });
    </script>
</body>
</html>
