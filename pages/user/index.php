<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
</head>

<body>
    <!-- header -->
    <?php include './../user/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row text-center">
            <!-- sidebar -->
            <?php include './../user/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">
                        <div class="mt-3 d-flex justify-content-end">
                            <!-- Search Bar -->
                            <div class="input-group rounded" style="max-width: 800px;">
                                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="search-bar">
                                <span class="input-group-text border-0" id="search-addon">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Content Table -->
                        <div class="container mt-5">
                            <table class="table table-bordered custom-table" id="research-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>File</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be inserted here by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const loginStatus = urlParams.get('login');

            if (loginStatus === 'success') {
                Swal.fire({
                    icon: "info",
                    title: "Welcome to Research Hub!"
                });
            }
            let url = new URL(window.location.href);
            url.searchParams.delete('login');
            window.history.replaceState({}, document.title, url.toString());

            // Sample data
            const sampleData = [
                { title: 'Advancements in AI Algorithms' },
                { title: 'Optimization Techniques for Data Processing' },
                { title: 'Impact of Blockchain on Financial Transactions' },
                { title: 'Machine Learning in Healthcare' },
                { title: 'Efficient Algorithms for Large Data Sets' }
            ];

            // Function to populate table
            function populateTable(data) {
                const tableBody = document.querySelector('#research-table tbody');
                tableBody.innerHTML = ''; // Clear existing rows

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><i class="fas fa-file-pdf"></i></td>
                        <td>${item.title}</td>
                        <td class="action-buttons">
                            <button class="btn btn-info" title="Comment"><i class="fas fa-comment"></i></button>
                            <button class="btn btn-warning" title="Favorite"><i class="fas fa-heart"></i></button>
                            <button class="btn btn-success" title="Download"><i class="fas fa-download"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            // Populate table with sample data
            populateTable(sampleData);
        });
    </script>
</body>

</html>
