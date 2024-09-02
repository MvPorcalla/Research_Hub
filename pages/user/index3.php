<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8dfec;
            margin: 0;
            height: 100vh; /* Full viewport height for vertical centering */
        }
        .centered-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            text-align: center; /* Center text horizontally */
        }
    </style>
</head>
<body>
    <!-- Container to center the content -->
    <div class="centered-container">
        <!-- Trefoil component -->
        <l-trefoil size="80" stroke="6" stroke-length="0.15" bg-opacity="0.1" speed="1.4" color="black"></l-trefoil>
    </div>

    <!-- Bootstrap JS (optional, for additional Bootstrap functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Import the ldrs library -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/trefoil.js"></script>
</body>
</html>
