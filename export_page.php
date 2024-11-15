<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Tạo đối tượng Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Thiết lập tiêu đề cho các cột
$sheet->setCellValue('A1', 'Ma hang');
$sheet->setCellValue('B1', 'Ten hang');
$sheet->setCellValue('C1', 'So luong');
$sheet->setCellValue('D1', 'Hinh anh');
$sheet->setCellValue('E1', 'Mo ta');
$sheet->setCellValue('F1', 'Gia hang');
$sheet->setCellValue('G1', 'Ma loai');

include('ketnoi.php');

$maloai = isset($_POST['maloai']) ? $_POST['maloai'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$limit = 5;
$start = ($page - 1) * $limit;

if ($maloai != '') {
    $sql_sanpham = "SELECT * FROM Sanpham WHERE Maloai='$maloai' LIMIT $start, $limit";
} else {
    $sql_sanpham = "SELECT * FROM Sanpham LIMIT $start, $limit";
}

$result_sanpham = $conn->query($sql_sanpham);
$rowIndex = 2;

if ($result_sanpham->num_rows > 0) {
    while ($row = $result_sanpham->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowIndex, $row['Mahang']);
        $sheet->setCellValue('B' . $rowIndex, $row['Tenhang']);
        $sheet->setCellValue('C' . $rowIndex, $row['Soluong']);
        $sheet->setCellValue('D' . $rowIndex, $row['Hinhanh']);
        $sheet->setCellValue('E' . $rowIndex, $row['Mota']);
        $sheet->setCellValue('F' . $rowIndex, $row['Giahang']);
        $sheet->setCellValue('G' . $rowIndex, $row['Maloai']);
        $rowIndex++;
       // echo $row['Tenhang'] . "\t" . 'images/' . $row['Hinhanh'] . "\n";
    }
} else {
    echo "Không có sản phẩm nào.\n";
}

$conn->close();

// $sql = "SELECT Mahang, Tenhang, Soluong, Hinhanh, Mota, Giahang, Maloai FROM sanpham";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     $rowIndex = 2; // Bắt đầu từ dòng 2 để ghi dữ liệu

//     // Lặp qua các hàng dữ liệu và ghi vào file Excel
//     while ($row = $result->fetch_assoc()) {
//         $sheet->setCellValue('A' . $rowIndex, $row['Mahang']);
//         $sheet->setCellValue('B' . $rowIndex, $row['Tenhang']);
//         $sheet->setCellValue('C' . $rowIndex, $row['Soluong']);
//         $sheet->setCellValue('D' . $rowIndex, $row['Hinhanh']);
//         $sheet->setCellValue('E' . $rowIndex, $row['Mota']);
//         $sheet->setCellValue('F' . $rowIndex, $row['Giahang']);
//         $sheet->setCellValue('G' . $rowIndex, $row['Maloai']);
//         $rowIndex++;
//     }
// } else {
//     echo "Không có dữ liệu";
// }

// $conn->close();

// Xuất file Excel
$writer = new Xlsx($spreadsheet);
$filename = 'danh_sach_san_pham.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>
