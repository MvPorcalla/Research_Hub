<?php
include_once "../includes/db.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['save_excel_data'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExt = ['xls', 'xlsx'];

        if (in_array($fileExt, $allowedExt)) {
            $inputFileNamePath = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $existing = 0;
            $notTwelve = 0;
            $dataCount = 0;

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip the header row

                $lastName = trim($row[0] ?? '');
                $firstName = trim($row[1] ?? '');
                $mi = trim($row[2] ?? '');
                $lrn = trim($row[3] ?? '');

                $dataCount++;

                if (strlen($lrn) != 12) {
                    $notTwelve++;
                    continue;
                }

                $sql = "SELECT `lrn_lrnid` FROM `lrn` WHERE `lrn_lrnid` = ?";
                $filter = [$lrn];
                $result = query($conn, $sql, $filter);

                if (empty($result)) {
                    $table = 'lrn';
                    $fields = [
                        'lrn_lastname' => $lastName,
                        'lrn_firstname' => $firstName,
                        'lrn_mi' => $mi,
                        'lrn_lrnid' => $lrn,
                        'lrn_status' => 'A' // Assuming new records are Active by default
                    ];
                    insert($conn, $table, $fields);
                } else {
                    $existing++;
                }
            }

            if ($existing > 0 || $notTwelve > 0) {
                header("Location: ../pages/admin/listLRN.php?exceptions={$existing}-{$notTwelve}-{$dataCount}");
            } else {
                header("Location: ../pages/admin/listLRN.php?importRecords=success");
            }
        } else {
            header("Location: ../pages/admin/listLRN.php?importRecords=invalid");
        }
    } else {
        header("Location: ../pages/admin/listLRN.php?importRecords=error");
    }
} else {
    header("Location: ../pages/admin/listLRN.php?importRecords=missing");
}
exit();
?>
