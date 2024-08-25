<?php
include_once "..\..\includes\db.php";
if ($_SESSION['user_type'] != 'A') header("location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABSTRACT - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">

    <style>
        .pdf-container {
            position: relative;
            width: 100%;
            height: 650px; /* Adjust height as needed */
            border: 1px solid #ddd; /* Optional border */
            border-radius: 8px; /* Rounded corners */
            overflow: hidden; /* Ensures no content overflow */
        }

        .pdf-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none; /* Removes default border */
        }

        .comment-container {
            position: relative;
            width: 100%;
            height: 650px; /* Adjust height as needed */
            border: 1px solid black;
            border-radius: 8px; /* Rounded corners */
            overflow: hidden; /* Ensures no content overflow */
        }

    </style>

</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid ">
        <div class="row">

            <?php 
                // Simulate fetching the record from the database
                $record_filedir = '../../uploads/records/MeowMadness.pdf';
            ?>

            <!-- Main content area -->
            <main class="col-md-12 ms-sm-auto col-lg-12 mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="pdf-container">
                                <iframe src="<?php echo htmlspecialchars($record_filedir); ?>" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="comment-container">
                                <p class='mt-5 ms-3'>Comment: reyal or pake</p>
                                <p class='ms-3'>Comment: Oh no Pake</p>
                                <p class='ms-3'>Comment: Reyale</p>
                            </div>
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
    <script src="..\..\includes\functions.js"></script>
    <script src="./scripts/fetchRecords.js"></script>

    <script>
       
    </script>
</body>

</html>