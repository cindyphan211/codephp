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
function getNextMahang($currentMaxId) {
    return 'SP' . str_pad($currentMaxId + 1, 3, '0', STR_PAD_LEFT); // Tạo mã sản phẩm như SP001, SP002, ...
}

// Hàm kiểm tra xem mã sản phẩm có tồn tại không
function checkDuplicateMahang($conn, $Mahang) {
    $sql = "SELECT COUNT(*) FROM sanpham WHERE Mahang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Mahang);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

// Xử lý file Excel
if (isset($_FILES['excel_file']['name'])) {
    $fileName = $_FILES['excel_file']['tmp_name'];

    try {
        // Load file Excel
        $spreadsheet = IOFactory::load($fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true); // Chuyển dữ liệu thành mảng 

        // Lấy giá trị lớn nhất hiện tại trong cột 'Mahang' với mã sản phẩm bắt đầu từ SP001
        $result = $conn->query("SELECT MAX(CAST(SUBSTRING(Mahang, 3) AS UNSIGNED)) AS max_id FROM sanpham");
        $row = $result->fetch_assoc();

        // Nếu không có sản phẩm nào, bắt đầu từ 0
        $currentMaxId = isset($row['max_id']) ? $row['max_id'] : 0;

        // Duyệt qua các dòng dữ liệu
        foreach ($data as $index => $rowData) {
            // Bỏ qua dòng tiêu đề hoặc dòng rỗng
            if ($index == 1 || empty(array_filter($rowData))) {
                continue;
            }

            // Lấy dữ liệu từ từng cột
            $Tenhang = isset($rowData['B']) ? trim($rowData['B']) : null;

            // Nếu `Tenhang` trống, bỏ qua dòng này mà không báo lỗi
            if (empty($Tenhang)) {
                continue;
            }

            $Soluong = isset($rowData['C']) ? (int)$rowData['C'] : 0;
            $Hinhanh = isset($rowData['D']) ? $rowData['D'] : null;
            $Mota = isset($rowData['E']) ? $rowData['E'] : null;
            $Giahang = isset($rowData['F']) ? (float)$rowData['F'] : 0.0;
            $Maloai = isset($rowData['G']) ? $rowData['G'] : null;

            // Kiểm tra dữ liệu trùng (theo tên hàng)
            $check_sql = "SELECT * FROM sanpham WHERE tenhang = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("s", $Tenhang);
            $stmt->execute();
            $check_result = $stmt->get_result();

            if ($check_result->num_rows > 0) {
                // Báo dữ liệu trùng mà không chặn chương trình
                echo "Dữ liệu bị trùng: $Tenhang<br>";
                $stmt->close();
                continue; // Bỏ qua dữ liệu trùng
            }

            // Tạo mã sản phẩm mới
            $currentMaxId++;
            $Mahang = getNextMahang($currentMaxId);

            // Kiểm tra mã sản phẩm có bị trùng không
            while (checkDuplicateMahang($conn, $Mahang)) {
                $currentMaxId++;
                $Mahang = getNextMahang($currentMaxId);
            }

            // Chuẩn bị câu lệnh SQL để chèn dữ liệu
            $sql = "INSERT INTO sanpham (Mahang, Tenhang, Soluong, Hinhanh, Mota, Giahang, Maloai) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssissss", $Mahang, $Tenhang, $Soluong, $Hinhanh, $Mota, $Giahang, $Maloai);

            // Thực thi câu lệnh SQL
            if (!$stmt->execute()) {
                echo "Lỗi khi chèn dữ liệu: " . $stmt->error . "<br>";
            } else {
                echo "Thêm sản phẩm thành công: $Tenhang với mã $Mahang<br>";
            }
            $stmt->close();
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
