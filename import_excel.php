<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlkho";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý file Excel
if (isset($_FILES['excel_file']['name'])) {
    $fileName = $_FILES['excel_file']['tmp_name'];

    try {
        // Load file Excel
        $spreadsheet = IOFactory::load($fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true); // Chuyển dữ liệu thành mảng

        // Bỏ qua dòng tiêu đề
        foreach ($data as $index => $row) {
            if ($index == 1) {
                continue; // Bỏ qua dòng đầu tiên
            }

            // Lấy dữ liệu từ từng cột
            $Mahang = $row['A'];
            $Tenhang = $row['B'];
            $Soluong = $row['C'];
            $Hinhanh = $row['D'];
            $Mota = $row['E'];
            $Giahang = $row['F'];
            $Maloai = $row['G'];

            // Chuẩn bị câu lệnh SQL
            $sql = "INSERT INTO sanpham (Mahang, Tenhang, Soluong, Hinhanh, Mota, Giahang, Maloai) 
                    VALUES ('$Mahang', '$Tenhang', $Soluong, '$Hinhanh', '$Mota', $Giahang, '$Maloai')";

            // Thực thi câu lệnh SQL
            if (!$conn->query($sql)) {
                echo "Lỗi khi chèn dữ liệu: " . $conn->error . "<br>";
            }
        }

        echo "Nhập dữ liệu thành công!";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    echo "Vui lòng tải lên file Excel.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Dữ Liệu</title>
</head>
<body>
    <h2>Import Dữ Liệu từ Excel</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="excel_file">Chọn file Excel:</label>
        <input type="file" name="excel_file" id="excel_file" required>
        <button type="submit">Import</button>
    </form>
</body>
</html>
