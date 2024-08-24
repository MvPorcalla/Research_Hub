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
            $dataCount = 0;

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip the header row

                $studentName = trim($row[0] ?? '');
                $lrn = trim($row[1] ?? '');

                $sql = "SELECT `lrn_lrnid` FROM `lrn` WHERE `lrn_lrnid` = ?";
                $filter = [$lrn];
                $result = query($conn, $sql, $filter);

                if (empty($result)) {
                    $table = 'lrn';
                    $fields = [
                        'lrn_student' => $studentName,
                        'lrn_lrnid' => $lrn
                    ];
                    insert($conn, $table, $fields);
                } else {
                    $existing++;
                }
                $dataCount++;
            }

            if ($existing > 0) {
                header("Location: ../pages/admin/listLRN.php?existingRecords={$existing}-{$dataCount}");
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