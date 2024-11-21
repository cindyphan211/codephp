<?php
    include 'ketnoi.php';

    // Kiểm tra nếu form đã được gửi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Lấy thông tin từ form
        $Mahang = $_POST['Mahang']; 
        $Tenhang = $_POST['Tenhang'];
        $Soluong = $_POST['Soluong'];
        $Mota = $_POST['Mota'];
        $maloai = $_POST['maloai'];
        

        $errors = [];

        // Kiểm tra nếu người dùng có chọn file ảnh mới
        if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
            // Lấy tên và đường dẫn file ảnh
            $Hinhanh = $_FILES['Image']['name'];
            $Hinhanh_tmp = $_FILES['Image']['tmp_name'];
            $file_size = $_FILES['Image']['size'];
            $file_extension = pathinfo($Hinhanh, PATHINFO_EXTENSION);

            // Kiểm tra đuôi ảnh (chỉ cho phép jpg và jpeg)
            if (!in_array(strtolower($file_extension), ['jpg', 'jpeg'])) {
                $errors[] = "Đuôi ảnh phải là JPG hoặc JPEG.";
            }

            // Kiểm tra kích thước ảnh (không được vượt quá 2MB)
            if ($file_size > 2 * 1024 * 1024) { 
                $errors[] = "Kích thước ảnh không được vượt quá 2MB.";
            }

            // Nếu không có lỗi, tiến hành upload hình ảnh
            if (empty($errors)) {
                
                $target_dir = "images/";
                $target_file = $target_dir . basename($Hinhanh);
                move_uploaded_file($Hinhanh_tmp, $target_file);
            }
        } else {
            $Hinhanh = $_POST['Hinhanh'];
        }

        // Nếu có lỗi, hiển thị thông báo và không thực hiện cập nhật
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
            $sql = "UPDATE sanpham SET 
                    Tenhang = '$Tenhang',
                    Soluong = '$Soluong',
                    Hinhanh = '$Hinhanh',
                    Mota = '$Mota',
                    Maloai = '$maloai'
                    WHERE Mahang = '$Mahang'";

            if ($conn->query($sql) === TRUE) {
                header("Location: sanpham.php"); 
            } else {
                echo "Lỗi: " . $conn->error;
            }
        }

        
        $conn->close();
    } else {
        // Nếu không phải là phương thức POST, chỉ hiển thị form
        echo "Vui lòng điền đầy đủ thông tin.";
    }
?>
