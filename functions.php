<?php
$filename = 'studentlist.csv';

// Tạo file CSV nếu chưa tồn tại
if (!file_exists($filename)) {
    $header = ["studentID", "name", "gender", "birth_date"];
    $file = fopen($filename, 'w');
    fputcsv($file, $header);
    fclose($file);
}

// Hàm kiểm tra ID duy nhất
function isUniqueID($studentID)
{
    global $filename;
    if (($handle = fopen($filename, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ","); // Bỏ tiêu đề
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] === $studentID) {
                fclose($handle);
                return false;
            }
        }
        fclose($handle);
    }
    return true;
}

// Hàm thêm sinh viên mới
function addStudent($data)
{
    global $filename;
    $file = fopen($filename, 'a');
    fputcsv($file, $data);
    fclose($file);
}

// Hàm xóa sinh viên
function deleteStudent($studentID)
{
    global $filename;
    $rows = array_map('str_getcsv', file($filename));
    $header = array_shift($rows);

    $updatedRows = array_filter($rows, function ($row) use ($studentID) {
        return $row[0] !== $studentID;
    });

    // Sắp xếp mảng theo studentID tăng dần
    usort($updatedRows, function ($a, $b) {
        return $a[0] <=> $b[0];
    });

    $file = fopen($filename, 'w');
    fputcsv($file, $header);
    foreach ($updatedRows as $row) {
        fputcsv($file, $row);
    }
    fclose($file);
}
?>