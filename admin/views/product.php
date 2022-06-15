<?php
    include_once "../db/config.php";
    include_once "../utils/dbhelper.php";
    include_once "../utils/session.php";
    include_once "../utils/validate.php";
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
                <textarea rows="3" id="screen" required name="screen">
                </textarea>

                <label for="RAM">Mô tả RAM</label>
                <input type="text" required name="RAM" id="RAM" placeholder="Nhập mô tả RAM">

                <label for="hardware">Mô tả ổ cứng</label>
                <input type="text" required name="hardware" id="hardware" placeholder="Nhập mô tả ổ cứng">

                <label for="OS">Hệ điều hành</label>
                <input type="text" required name="OS" id="OS" placeholder="Nhập tên hệ điều hành">
        
                <label for="CPU">CPU</label>
                <input type="text" required name="CPU" id="CPU" placeholder="Nhập chip xử lý">
        
                <label for="VGA">VGA</label>
                <textarea rows="3" id="VGA" required name="VGA">
                </textarea>
        
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
        <script type="module" src="js/components/addProduct.js"></script>';
    }elseif($_GET["view"]=="product"){
        $id = $_GET["id"];
        $query = 'select model,  brands.name as "nameBrand", screen, RAM, hardware, OS, CPU,
        VGA, background, warranty, discount, color, users.name as "nameUser"
        from brands inner join products on brands.id = products.brand_id inner join
        users on products.created_by = users.id where products.id = '.$id.' limit 1;';
        $dataQueryProductDetail = executeResult($query,true);
        $background = baseUrl."store/".$dataQueryProductDetail["background"];
        $query = 'select * from product_capacities where product_id = '.$id.';';
        $dataQueryCapacitiesDeaitl = executeResult($query);
        $capacitiesElement ="";
        
        foreach($dataQueryCapacitiesDeaitl as $item){
            $capacitiesHref = "index.php?view=change-capacity-product&id=".$item['id'];
            $capacitiesElement=$capacitiesElement.'
                <tr>
                    <td>'.$item["capacity_name"].'</td>
                    <td>'.$item["quantity"].'</td>
                    <td>'.$item["price"].'</td>
                    <td>
                        <a class="btn" href="'.$capacitiesHref.'" data-id="'.$item['id'].'">Sửa</a>
                    </td>
                </tr>
            ';
        }
        echo '
        <div class="container">
            <h2 style="text-align:center">Thông tin sản phẩm</h2>
            <div class="product__detail">
                <ul class="product__detail__infor">
                    <li><span>Tên</span><span>'.$dataQueryProductDetail["model"].'</span> </li>
                    <li><span>Hãng sản xuất</span><span>'.$dataQueryProductDetail["nameBrand"].'</span> </li>
                    <li><span>Màn hình</span><span>'.$dataQueryProductDetail["screen"].'</span> </li>
                    <li><span>RAM</span><span>'.$dataQueryProductDetail["RAM"].'</span> </li>
                    <li><span>Hardware</span><span>'.$dataQueryProductDetail["hardware"].'</span> </li>
                    <li><span>Hệ điều hành</span><span>'.$dataQueryProductDetail["OS"].'</span> </li>
                    <li><span>CPU</span><span>'.$dataQueryProductDetail["CPU"].'</span> </li>
                    <li><span>VGA</span><span>'.$dataQueryProductDetail["VGA"].'</span> </li>
                    <li><span>Ảnh</span><span><img src="'.$background.'" alt=""></span> </li>
                    <li><span>Bảo hành</span><span>'.$dataQueryProductDetail["warranty"].'</span> </li>
                    <li><span>Giảm giá</span><span>'.$dataQueryProductDetail["discount"].'%</span> </li>
                    <li><span>Màu</span><span>'.$dataQueryProductDetail["color"].'</span> </li>
                    <li><span>Tạo bởi</span><span>'.$dataQueryProductDetail["nameUser"].'</span> </li>
                </ul>
                <div class="product__detail__capacity">
                    <table border="1">
                        <tr>
                            <th>Ram/hardware</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                        '.$capacitiesElement.'
                    </table>
                </div>
                <a class="btn" href="index.php?view=add-capacity-product&id-product='.$_GET["id"].'">Thêm</a>
                <a class="btn" href="index.php?view=change-product&id='.$_GET["id"].'">Sửa</a>
            </div>
        </div>
        ';
    }else if($_GET["view"]=="change-capacity-product" && !empty($_GET["id"])){
        $query = 'select * from product_capacities where id = '.$_GET["id"].' limit 1;';
        $dataQueryCapacitiesDeaitl = executeResult($query,true);
        echo '
        <div class="container">
            <form action="controller/product.php?id='.$_GET["id"].'" method="POST">
                <label for="capacity_name">Dung lượng Ram/ hard_drive bán</label>
                <input type="text" required name="capacity_name" value="'.$dataQueryCapacitiesDeaitl["capacity_name"].'" id="capacity_name" placeholder="Nhập dung lượng Ram/ hard_drive">
        
                <label for="price">Giá bán</label>
                <input type="number" value="'.$dataQueryCapacitiesDeaitl["price"].'" required name="price" id="price">
        
                <label for="quantity">Số lượng bán</label>
                <input type="number" value="'.$dataQueryCapacitiesDeaitl["quantity"].'" required name="quantity" id="quantity">
                <input type="hidden" name="crud_request" value="change-capacity-product">
                <button type="submit" style="margin-top: 10px" class="btn">Lưu</button>
            </form>
        </div>
        ';
    }else if($_GET["view"]=="add-capacity-product" && !empty($_GET["id-product"])){
        echo '
        <div class="container">
            <form action="controller/product.php?id-product='.$_GET["id-product"].'" method="POST">
                <label for="capacity_name">Dung lượng Ram/ hard_drive bán</label>
                <input type="text" required name="capacity_name"  id="capacity_name" placeholder="Nhập dung lượng Ram/ hard_drive">
        
                <label for="price">Giá bán</label>
                <input type="number"  required name="price" id="price">
        
                <label for="quantity">Số lượng bán</label>
                <input type="number"  required name="quantity" id="quantity">
                <input type="hidden" name="crud_request" value="add-capacity-product">
                <button type="submit" style="margin-top: 10px" class="btn">Lưu</button>
            </form>
        </div>
        ';
    }else if($_GET["view"]=="change-product" && !empty($_GET["id"])){
        $query = "select id, name from brands";
        $queryResult = executeResult($query);
        $query = "select brand_id, model, screen, RAM, hardware, OS, CPU, VGA, background, warranty, 
        discount, color from products where id = ".$_GET["id"];
        $queryProductResult = executeResult($query,true);
        $background = baseUrl."store/".$queryProductResult["background"];
        $brandOptions = '';
        foreach($queryResult as $item){
            if($item["id"]==$queryProductResult["brand_id"]){
                $brandOptions=$brandOptions.'<option selected value="'.$item["id"].'">'.$item["name"].'</option>';
            }else{
                $brandOptions=$brandOptions.'<option value="'.$item["id"].'">'.$item["name"].'</option>';
            }
        };
        echo '
            <div class="container__detail__product">
            <form action="controller/product.php?id='.$_GET["id"].'" enctype="multipart/form-data" method="POST">
                <label for="brand">Hãng sản xuất</label>
                <select required name="brand_id" id="brand">
                    '.$brandOptions.'
                </select>
        
                <label for="model">Tên sản phẩm</label>
                <input type="text" required value="'.$queryProductResult["model"].'" name="model" id="model" placeholder="Nhập tên sản phẩm">
                
                <label for="screen">Loại màn hình</label>
                <textarea rows="3" id="screen" required name="screen">
                '.$queryProductResult["screen"].'
                </textarea>

                <label for="RAM">Mô tả RAM</label>
                <input type="text" required value="'.$queryProductResult["RAM"].'" name="RAM" id="RAM" placeholder="Nhập mô tả RAM">

                <label for="hardware">Mô tả ổ cứng</label>
                <input type="text" required value="'.$queryProductResult["hardware"].'" name="hardware" id="hardware" placeholder="Nhập mô tả ổ cứng">

                <label for="OS">Hệ điều hành</label>
                <input type="text" required value="'.$queryProductResult["OS"].'" name="OS" id="OS" placeholder="Nhập tên hệ điều hành">
        
                <label for="CPU">CPU</label>
                <input type="text" required value="'.$queryProductResult["CPU"].'" name="CPU" id="CPU" placeholder="Nhập chip xử lý">
        
                <label for="VGA">VGA</label>
                <textarea rows="3" id="VGA" required name="VGA">
                '.$queryProductResult["VGA"].'
                </textarea>
                <label for="background">Hình ảnh</label>
                <img style="height: 60px" src="'.$background.'" >
                <input type="file" name="background" id="background">
        
                <label for="warranty">Thời gian bảo hành</label>
                <input type="text" required value="'.$queryProductResult["warranty"].'" name="warranty" id="warranty" placeholder="Nhập thời gian bảo hành">
        
                <label for="discount">Giảm giá</label>
                <input type="number" required value="'.$queryProductResult["discount"].'" name="discount" id="discount">
        
                <label for="color">Màu sắc</label>
                <input type="text" required value="'.$queryProductResult["color"].'" name="color" id="color" placeholder="Nhập màu sắc">
                
                <input type="hidden" name="crud_request" value="change-product">
                <button type="submit" style="margin-top: 10px" class="btn">Lưu</button>
            </form>
        </div>';
    }
?>
