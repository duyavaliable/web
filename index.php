<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class membership managements</title>
    <link rel="stylesheet" href="student.css">
</head>

<body>
    <header>
        <h1>Class membership management</h1>
    </header>

    <section class="table-section">
        <div class="header">
            <h2>Student List</h2>
            <div class="button-group">
                <a href="add_student.php" class="add-button-link">
                    <button type="button" class="add-button">Add</button>
                </a>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Đường dẫn đến tệp CSV
                    $csvFile = 'studentlist.csv';

                    // Mở tệp CSV
                    if (($handle = fopen($csvFile, "r")) !== FALSE) {
                        // Bỏ qua dòng tiêu đề
                        fgetcsv($handle, 1000, ",");

                        $rows = [];
                        // Đọc từng dòng của tệp CSV
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $rows[] = $data;
                        }
                        // Đóng tệp CSV
                        fclose($handle);

                        // Sắp xếp mảng theo studentID tăng dần
                        usort($rows, function ($a, $b) {
                            return $a[0] <=> $b[0];
                        });

                        // Hiển thị các hàng đã được sắp xếp
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row[0]) . "</td>";
                            echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                            echo "<td>" . htmlspecialchars($row[2]) . "</td>";
                            echo "<td>" . htmlspecialchars($row[3]) . "</td>";
                            echo "<td>";
                            echo "<form method='POST' action='delete_student.php'>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<input type='hidden' name='deleteID' value='" . htmlspecialchars($row[0]) . "'>";
                            echo "<button class='delete-button' type='submit'>Xóa</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Không thể mở tệp CSV</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>