<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMORA-LUXURY ACCESSORIES</title>
    <style>
    <?php
    include 'style.css';
    ?>

    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <!-- Danh mục sản phẩm -->
        <?php include 'menu.php'; ?>       
        <!-- Nội dung sản phẩm -->
        <div class="content">
            <!-- sản phẩm -->
            <?php
                // Xử lý lọc sản phẩm theo loại
                $maloai = isset($_GET['maloai']) ? $_GET['maloai'] : '';

                // Phân trang
                $limit = 6;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                // Truy vấn sản phẩm
                if ($maloai != '') {
                    $sql_sanpham = "SELECT * FROM Sanpham WHERE Maloai='$maloai' LIMIT $start, $limit";
                } else {
                    $sql_sanpham = "SELECT * FROM Sanpham LIMIT $start, $limit";
                }

                $result_sanpham = $conn->query($sql_sanpham);
                
                if ($result_sanpham->num_rows > 0) {
                
                    while($row = $result_sanpham->fetch_assoc()) {
                        echo "<div class='product-item'>";
                        echo "<div class='image-container'>";
                        echo "<img src='images/".$row['Hinhanh']."' alt='".$row['Tenhang']."'>";
                        echo "<div class='tooltip'><a href='chitietsp.php?Mahang={$row['Mahang']}'>Xem chi tiết</a></div>";
                        echo "</div>";
                        echo "<h3>".$row['Tenhang']."</h3>";
                        echo "<p>" . number_format($row['Giahang']) . " đ</p>";
                        echo "</div>";
                      
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có sản phẩm nào.</td></tr>";
                }
            ?>            
        <div>

        <!-- Phân trang -->
        <div class="pagination">
            <?php
                // Đếm tổng số sản phẩm để tính tổng số trang
                $sql_count = "SELECT COUNT(Mahang) AS total FROM Sanpham";
                $result_count = $conn->query($sql_count);
                $row_count = $result_count->fetch_assoc();
                $total_pages = ceil($row_count['total'] / $limit);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='Sanpham.php?page=$i".($maloai ? "&maloai=$maloai" : "")."'>$i</a>";
                }
            ?>
          </div>                
     </div>
    </div>
    </div>
    <?php include 'footer.php'?>
    
    
    
    
    
</body>
</html>
