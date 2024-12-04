<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collapsible Tables</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .curtain {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .curtain-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            cursor: pointer;
        }

        .curtain-header:hover {
            background-color: #e9ecef;
        }

        .curtain-content {
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Curtain Style Tables</h1>

        <!-- First Curtain -->
        <div class="curtain mb-3">
            <div class="curtain-header" data-bs-toggle="collapse" data-bs-target="#table1">
                <h5 class="mb-0">LRN List</h5>
            </div>
            <div id="table1" class="collapse show curtain-content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>LRN</th>
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>123456789</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>987654321</td>
                            <td>Jane Smith</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Second Curtain -->
        <div class="curtain">
            <div class="curtain-header" data-bs-toggle="collapse" data-bs-target="#table2">
                <h5 class="mb-0">Employee Numbers List</h5>
            </div>
            <div id="table2" class="collapse curtain-content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Number</th>
                            <th>Employee Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>EMP001</td>
                            <td>Anna Johnson</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>EMP002</td>
                            <td>Mark Lee</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
