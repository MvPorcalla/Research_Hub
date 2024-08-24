<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histories - LNHS Research Hub</title>
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
                        <div class="mt-5 mb-3">
                            <h1 class="admin-subtitle">History</h1>
                        </div>

                        <div class="side-container">
                            <?php
                                $records = [
                                    ['record_id' => 'Advancements in Artificial Intelligence', 'date' => '2024-08-21'],
                                    ['record_id' => 'Impact of Climate Change on Agriculture', 'date' => '2024-08-21'],
                                    ['record_id' => 'Statistical Data on Renewable Energy', 'date' => '2024-08-20'],
                                    ['record_id' => 'Quantum Computing and Cryptography', 'date' => '2024-08-20'],
                                    ['record_id' => 'New Findings in Genetic Engineering', 'date' => '2024-08-19'],
                                    ['record_id' => 'How are you baby girl', 'date' => '2024-08-29'],
                                    // Add more records as needed
                                ];

                                // Sort records by date in descending order
                                usort($records, function($a, $b) {
                                    return strtotime($b['date']) - strtotime($a['date']);
                                });

                                // Group records by date
                                $groupedRecords = [];
                                foreach ($records as $record) {
                                    $groupedRecords[$record['date']][] = $record['record_id'];
                                }

                                foreach ($groupedRecords as $date => $recordsOnDate) {
                                    echo '<div class="mb-4">';
                                    // Display the date at the top left
                                    echo '<div class="text-start text-muted mb-2"><strong>Date: ' . $date . '</strong></div>';
                                    echo '<table class="table table-bordered">';
                                    echo '<tbody>';
                                    foreach ($recordsOnDate as $record) {
                                        echo '<tr>';
                                        echo '<td class="col-md-11 text-start">' . htmlspecialchars($record) . '</td>';
                                        echo '<td class="col-md-1 text-center">';
                                        echo '<button class="btn btn-danger btn-sm mx-1 delete-button">';
                                        echo '<i class="fas fa-trash-alt"></i>';  // Trash can icon for delete
                                        echo '</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';
                                }
                            ?>
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

</body>

</html>
