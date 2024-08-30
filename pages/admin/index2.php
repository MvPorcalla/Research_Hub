<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table with Filters and Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

        <!-- Filters and Search Bar -->
        <div class="filter-container d-flex align-items-center mb-4">
            <div class="mr-3">
                <label for="monthFilter" class="mr-2">Month:</label>
                <select id="monthFilter" class="form-control">
                    <option value="">All</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>
            <div class="mr-3">
                <label for="yearFilter" class="mr-2">Year:</label>
                <select id="yearFilter" class="form-control">
                    <option value="">All</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                </select>
            </div>
            <div class="mr-3">
                <label for="trackFilter" class="mr-2">Track/Strand:</label>
                <select id="trackFilter" class="form-control">
                    <option value="">All</option>
                    <option value="STEM">STEM</option>
                    <option value="ABM">ABM</option>
                    <option value="HUMSS">HUMSS</option>
                </select>
            </div>
            <div class="search-bar">
                <input id="searchBar" type="text" class="form-control" placeholder="Search...">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript to handle filtering and search logic
        const monthFilter = document.getElementById('monthFilter');
        const yearFilter = document.getElementById('yearFilter');
        const trackFilter = document.getElementById('trackFilter');
        const searchBar = document.getElementById('searchBar');
        const dataTable = document.getElementById('dataTable').getElementsByTagName('tbody')[0];

        // Sample data
        const data = [
            { title: 'shesh taena mo', monthYear: 'January 2024', track: 'STEM' },
            { title: 'sample shit', monthYear: 'January 2023', track: 'ABM' },
            { title: 'Optimizing Web Performance: A Comparative Study of Frontend Frameworks', monthYear: 'January 2024', track: 'STEM' },
            { title: 'Exploring the Influence of Cat Videos on Workplace Productivity', monthYear: 'February 2023', track: 'HUMSS' },
            { title: 'The Adventures of a Code-Slinging Ninja: Tales from the Frontend', monthYear: 'June 2023', track: 'STEM' },
            { title: 'How to Survive and Thrive in the Age of Zoom Fatigue', monthYear: 'March 2024', track: 'ABM' },
            { title: 'Meow Madness shesh', monthYear: 'January 2024', track: 'STEM' },
        ];

        function renderTable() {
            dataTable.innerHTML = '';
            const searchText = searchBar.value.toLowerCase();
            const monthText = monthFilter.value.toLowerCase();
            const yearText = yearFilter.value.toLowerCase();
            const trackText = trackFilter.value.toLowerCase();
            
            const filteredData = data.filter(item => {
                const [itemMonth, itemYear] = item.monthYear.split(' ');
                return (!monthFilter.value || itemMonth.toLowerCase() === monthText) &&
                       (!yearFilter.value || itemYear.toLowerCase() === yearText) &&
                       (!trackFilter.value || item.track.toLowerCase() === trackText) &&
                       (item.title.toLowerCase().includes(searchText) ||
                        item.monthYear.toLowerCase().includes(searchText) ||
                        item.track.toLowerCase().includes(searchText));
            });
            
            filteredData.forEach(item => {
                const row = dataTable.insertRow();
                row.insertCell(0).textContent = item.title;
                row.insertCell(1).textContent = item.monthYear;
                row.insertCell(2).textContent = item.track;
            });
        }

        monthFilter.addEventListener('change', renderTable);
        yearFilter.addEventListener('change', renderTable);
        trackFilter.addEventListener('change', renderTable);
        searchBar.addEventListener('input', renderTable);

        renderTable(); // Initial render
    </script>
</body>
</html>
