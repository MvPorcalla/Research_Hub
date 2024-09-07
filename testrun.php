<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Text Suggestions</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .input-group {
            position: relative;
            width: 100%;
        }

        .form-control {
            position: relative; /* Needed to position suggestion text absolutely */
            padding-left: 0.75em; /* Adjust to accommodate suggestion text */
        }

        .suggestion-text {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            line-height: 2.5em; /* Align with input line height */
            color: #999;
            pointer-events: none; /* Prevent interaction */
            overflow-x: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            user-select: none; /* Prevent text selection */
            padding: 0 0.75em; /* Align with input padding */
            width: 100%; /* Fill the input width */
            box-sizing: border-box; /* Include padding in width calculation */
            z-index: 1; /* Ensure it stays above the input text */
            background-color: rgba(255, 255, 255, 0.8); /* Slight background to highlight suggestion */
        }

        .form-control:focus + .suggestion-text {
            display: none; /* Hide suggestion text when input is focused */
        }
    </style>
</head>
<body class="">
<div class="container-fluid">
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <h3>NLP SAMPLE</h3>
            </div>
            <div class="col-md-6 position-relative">
                <div class="d-flex">
                    <form id="search-form" class="d-flex w-100" onsubmit="return false;">
                        <div class="input-group overflow-x-hidden border border-dark position-relative w-100">
                            <input class="form-control overflow-x-hidden bg-transparent" type="text" id="query" placeholder="Search" aria-label="Search" autocomplete="off">
                            <span id="suggestion-text" class="suggestion-text overflow-x-hidden"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table id="records-table" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Month/Year</th>
                        <th>Author</th>
                        <th>Track/Strand</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <!-- Data rows will be inserted here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JavaScript for table and search functionality -->
<script>
    // Sample data for table
    const tableData = [
        { title: "Meow Madness", monthYear: "Sep/2024", author: "John Doe", trackStrand: "Web Development" },
        { title: "Bark Bonanza to Data Science", monthYear: "Aug/2024", author: "Jane Smith", trackStrand: "Data Science" },
       
    ];

    // Function to render data into the table
    function renderTable(filteredData = tableData) {
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = ''; // Clear existing rows
        
        filteredData.forEach(item => {
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>${item.title}</td>
                <td>${item.monthYear}</td>
                <td>${item.author}</td>
                <td>${item.trackStrand}</td>
                <td>
                    <button class="btn btn-primary btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            `;
            
            tableBody.appendChild(row);
        });
    }

    // Function to filter data based on search query
    function filterData(query) {
        const lowerCaseQuery = query.toLowerCase();
        return tableData.filter(item =>
            item.title.toLowerCase().includes(lowerCaseQuery) ||
            item.author.toLowerCase().includes(lowerCaseQuery) ||
            item.trackStrand.toLowerCase().includes(lowerCaseQuery)
        );
    }

    // Event listener for search input
    document.getElementById('query').addEventListener('input', function() {
        const query = this.value.trim();
        const filteredData = filterData(query);
        renderTable(filteredData);
        updateSuggestionText(query); // Call the function from the external file
    });

    // Call the function to render data on page load
    renderTable();
</script>

<!-- Include the custom suggestions script -->
<script src="./scripts/searchSuggestion.js"></script>
</body>
</html>
