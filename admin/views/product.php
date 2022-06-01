<?php
    include_once "../db/config.php";
    include_once "../utils/dbhelper.php";
    if($_GET["view"]=="new-product"){
        $query = "select id, name from brands";
        $queryResult = executeResult($query);
        $brandOptions = '';
        foreach($queryResult as $item){
            $brandOptions=$brandOptions.'<option value="'.$item["id"].'">'.$item["name"].'</option>';
        };
        echo '
            <div class="container__detail__product">
            <form action="controller/product.php" enctype="multipart/form-data" method="POST">
                <label for="brand">Hãng sản xuất</label>
                <select required name="brand_id" id="brand">
                    '.$brandOptions.'
                </select>
        
                <label for="model">Tên sản phẩm</label>
                <input type="text" required name="model" id="model" placeholder="Nhập tên sản phẩm">
                
                <label for="screen">Loại màn hình</label>
                <input type="text" required name="screen" id="screen" placeholder="Nhập loại màn hình">

                <label for="RAM">Mô tả RAM</label>
                <input type="text" required name="RAM" id="RAM" placeholder="Nhập mô tả RAM">

                <label for="hardware">Mô tả ổ cứng</label>
                <input type="text" required name="hardware" id="hardware" placeholder="Nhập mô tả ổ cứng">

                <label for="OS">Hệ điều hành</label>
                <input type="text" required name="OS" id="OS" placeholder="Nhập tên hệ điều hành">
        
                <label for="CPU">CPU</label>
                <input type="text" required name="CPU" id="CPU" placeholder="Nhập chip xử lý">
        
                <label for="VGA">VGA</label>
                <input type="text" required name="VGA" id="VGA" placeholder="Nhập card đồ họa">
        
                <label for="background">Hình ảnh</label>
                <input type="file" required name="background" id="background">
        
                <label for="warranty">Thời gian bảo hành</label>
                <input type="text" required name="warranty" id="warranty" placeholder="Nhập thời gian bảo hành">
        
                <label for="discount">Giảm giá</label>
                <input type="number" required name="discount" id="discount">
        
                <label for="color">Màu sắc</label>
                <input type="text" required name="color" id="color" placeholder="Nhập màu sắc">
                
                <label for="capacity_name">Dung lượng Ram/ hard_drive bán</label>
                <input type="text" required name="capacity_name" id="capacity_name" placeholder="Nhập dung lượng Ram/ hard_drive">
        
                <label for="price">Giá bán</label>
                <input type="number" required name="price" id="price">
        
                <label for="quantity">Số lượng bán</label>
                <input type="number" required name="quantity" id="quantity">
                <input type="hidden" name="crud_request" value="add-newproduct">
                <button type="submit" style="margin-top: 10px" class="btn">Lưu</button>
            </form>
        </div>
        <script src="js/components/addProduct.js"></script>';
    }elseif($_GET["view"]=="product"){
        echo '
        <div class="container">
            <h2 style="text-align:center">Thông tin sản phẩm</h2>
            <div class="product__detail">
        <ul class="product__detail__infor">
            <li><span>Tên</span>: <span></span> </li>
            <li><span>Hãng sản xuất</span>: <span></span> </li>
            <li><span>Màn hình</span>: <span></span> </li>
            <li><span>RAM</span>: <span></span> </li>
            <li><span>Hardware</span>: <span></span> </li>
            <li><span>Hệ điều hành</span>: <span></span> </li>
            <li><span>CPU</span>: <span></span> </li>
            <li><span>VGA</span>: <span></span> </li>
            <li><span>Ảnh</span>: <span><img src="" alt=""></span> </li>
            <li><span>Bảo hành</span>: <span></span> </li>
            <li><span>Giảm giá</span>: <span></span> </li>
            <li><span>Màu</span>: <span></span> </li>
            <li><span>Tạo bởi</span>: <span></span> </li>
        </ul>
        <div class="product__detail__capacity">
            <table border="1">
                <tr>
                    <th>Ram/hardware</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
                <tr>
                    
                </tr>
            </table>
        </div>
    </div>
        </div>
        ';
    }
?>
