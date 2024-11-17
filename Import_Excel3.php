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

// Hàm lấy mã sản phẩm tiếp theo
function getNextMahang($conn, $currentMaxId) {
    return 'SP' . str_pad($currentMaxId + 1, 4, '0', STR_PAD_LEFT);
}

// Xử lý file Excel
if (isset($_FILES['excel_file']['name'])) {
    $fileName = $_FILES['excel_file']['tmp_name'];

    try {
        // Load file Excel
        $spreadsheet = IOFactory::load($fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true); // Chuyển dữ liệu thành mảng

        // Lấy giá trị lớn nhất hiện tại trong cột 'mahang'
        $result = $conn->query("SELECT MAX(CAST(SUBSTRING(mahang, 3) AS UNSIGNED)) AS max_id FROM sanpham");
        $row = $result->fetch_assoc();
        $currentMaxId = $row['max_id'] ?? 0;

        // Duyệt qua các dòng dữ liệu
        foreach ($data as $index => $row) {
            if ($index == 1) {
                continue; // Bỏ qua dòng tiêu đề
            }

            // Lấy dữ liệu từ từng cột
            $Tenhang = $row['B'];
            $Soluong = $row['C'];
            $Hinhanh = $row['D'];
            $Mota = $row['E'];
            $Giahang = $row['F'];
            $Maloai = $row['G'];

            // Kiểm tra dữ liệu trùng
            $check_sql = "SELECT * FROM sanpham WHERE tenhang = '$Tenhang'";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                echo "Dữ liệu bị trùng: $Tenhang<br>";
                continue; // Bỏ qua dữ liệu trùng
            }

            // Lấy mã sản phẩm mới
            $currentMaxId++;
            $Mahang = getNextMahang($conn, $currentMaxId);

            // Chuẩn bị câu lệnh SQL
            $sql = "INSERT INTO sanpham (Mahang, Tenhang, Soluong, Hinhanh, Mota, Giahang, Maloai) 
                    VALUES ('$Mahang', '$Tenhang', $Soluong, '$Hinhanh', '$Mota', $Giahang, '$Maloai')";

            // Thực thi câu lệnh SQL
            if (!$conn->query($sql)) {
                echo "Lỗi khi chèn dữ liệu: " . $conn->error . "<br>";
            } else {
                echo "Thêm sản phẩm thành công: $Tenhang với mã $Mahang<br>";
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
