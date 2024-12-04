<?php
include_once "../includes/db.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['save_excel_data'])) {

    $number_type = $_POST['number_type'];    

    [$table, $column, $id, $digit] = match($number_type) {
        'lrn' => ['lrn', 'lrn', 'lrnid', 12],
        'den' => ['teachers', 'teacher', 'depedno', 7],
    };

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExt = ['xls', 'xlsx'];

        if (in_array($fileExt, $allowedExt)) {
            $inputFileNamePath = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $existing = 0;
            $notNumber = 0;
            $dataCount = 0;

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip the header row

                $lastName = trim($row[0] ?? '');
                $firstName = trim($row[1] ?? '');
                $mi = trim($row[2] ?? '');
                $number = trim($row[3] ?? '');

                $dataCount++;

                if (($number_type == "lrn" && strlen($number) != 12) || ($number_type == "den" && strlen($number) != 7)) {
                    $notNumber++;
                    continue;
                }                

                $sql = ($number_type == "lrn")
                    ? "SELECT `lrn_lrnid` FROM `lrn` WHERE `lrn_lrnid` = ?"
                    : "SELECT `teacher_depedno` FROM `teachers` WHERE `teacher_depedno` = ?";
                $filter = [$number];
                $result = query($conn, $sql, $filter);

                if (empty($result)) {
                    $fields = [
                        "{$column}_lastname" => $lastName,
                        "{$column}_firstname" => $firstName,
                        "{$column}_mi" => $mi,
                        "{$column}_{$id}" => $number,
                        "{$column}_status" => 'A' // Assuming new records are Active by default
                    ];
                    insert($conn, $table, $fields);
                } else {
                    $existing++;
                }
            }

            if ($existing > 0 || $notNumber > 0) {
                header("Location: ../pages/admin/ListIDPage.php?exceptions={$existing}-{$notNumber}-{$digit}-{$dataCount}");
            } else {
                header("Location: ../pages/admin/ListIDPage.php?importRecords=success");
            }
        } else {
            header("Location: ../pages/admin/ListIDPage.php?importRecords=invalid");
        }
    } else {
        header("Location: ../pages/admin/ListIDPage.php?importRecords=error");
    }
}
exit();
