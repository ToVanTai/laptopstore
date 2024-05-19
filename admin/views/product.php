<?php
include_once __DIR__ . "/../../utils/index.php";
if ($_GET["view"] == "new-product") {
    echo '
            <div class="main-form">
                <div class="form-container container__detail__product">
                    <h1 class="form-title">Thêm mới sản phẩm</h1>
                    <form id="form-add-product" enctype="multipart/form-data" method="POST">
                        <div class="main-user-info">
                            <div class="user-input-box">
                                <label for="brand">Hãng sản xuất</label>
                                <select required name="brand_id" id="brand">
                                </select>
                            </div>

                            <div class="user-input-box">
                                <label for="model">Tên sản phẩm</label>
                                <input type="text" required name="model" id="model" placeholder="Nhập tên sản phẩm">
                            </div>

                            <div class="user-input-box">
                                <label for="screen">Loại màn hình</label>
                                <textarea rows="3" id="screen" required name="screen"></textarea>
                            </div>

                            <div class="user-input-box">
                                <label for="RAM">Mô tả RAM</label>
                                <input type="text" required name="RAM" id="RAM" placeholder="Nhập mô tả RAM">
                            </div>

                            <div class="user-input-box">
                                <label for="hardware">Mô tả ổ cứng</label>
                                <input type="text" required name="hardware" id="hardware" placeholder="Nhập mô tả ổ cứng">
                            </div>

                            <div class="user-input-box">
                                <label for="OS">Hệ điều hành</label>
                                <input type="text" required name="OS" id="OS" placeholder="Nhập tên hệ điều hành">
                            </div>

                            <div class="user-input-box">
                                <label for="CPU">CPU</label>
                                <input type="text" required name="CPU" id="CPU" placeholder="Nhập chip xử lý">
                            </div>

                            <div class="user-input-box">
                                <label for="VGA">VGA</label>
                                <textarea rows="3" id="VGA" required name="VGA"></textarea>
                            </div>

                            <div class="user-input-box">
                                <label for="background">Hình ảnh</label>
                                <input type="file" required name="background" id="background">
                            </div>

                            <div class="user-input-box">
                                <label for="warranty">Thời gian bảo hành</label>
                                <input type="text" required name="warranty" id="warranty" placeholder="Nhập thời gian bảo hành">
                            </div>

                            <div class="user-input-box">
                                <label for="discount">Giảm giá</label>
                                <input type="number" required name="discount" id="discount">
                            </div>

                            <div class="user-input-box">
                                <label for="color">Màu sắc</label>
                                <input type="text" required name="color" id="color" placeholder="Nhập màu sắc">
                            </div>

                            <div class="user-input-box">
                                <label for="capacity_name">Dung lượng Ram/ hard_drive bán</label>
                                <input type="text" required name="capacity_name" id="capacity_name"
                                    placeholder="Nhập dung lượng Ram/ hard_drive">
                            </div>

                            <div class="user-input-box">
                                <label for="price">Giá bán</label>
                                <input type="number" required name="price" id="price">
                            </div>

                            <div class="user-input-box">
                                <label for="quantity">Số lượng bán</label>
                                <input type="number" required name="quantity" id="quantity">
                            </div>
                        </div>
                        <input type="hidden" name="crud_request" value="add-newproduct">
                        <button type="submit" style="margin-top: 10px" class="btn">Lưu</button>
                    </form>
                </div>
            </div>
            <script type="module" src="js/components/addProduct.js"></script>';
} elseif ($_GET["view"] == "product") {
    echo '
        <div class="main-form-view">
            <div class="form-view-container">
                <h1 class="form-title">Thông tin sản phẩm</h1>
                <div id="detail-container">

                </div>
            </div>
        </div>
        <script type="module" src="js/components/product.js"></script>';
} else if ($_GET["view"] == "change-capacity-product" && !empty($_GET["id"])) {
    echo '
        <div class="container">
            <form id="form-change-capacity" method="POST">
                <label for="capacity_name">Dung lượng Ram/ hard_drive bán</label>
                <input type="text" required name="capacity_name" value="" id="capacity_name" placeholder="Nhập dung lượng Ram/ hard_drive">
        
                <label for="price">Giá bán</label>
                <input type="number" value="" required name="price" id="price">
        
                <label for="quantity">Số lượng bán</label>
                <input type="number" value="" required name="quantity" id="quantity">
                <input type="hidden" name="crud_request" value="change-capacity-product">
                <button type="submit" style="margin-top: 10px" class="btn">Lưu</button>
            </form>
        </div>
        <script type="module" src="js/components/changeCapacityProduct.js"></script>';
} else if ($_GET["view"] == "add-capacity-product" && !empty($_GET["id-product"])) {
    echo '
        <div class="container">
            <form id="form-add-capacity" method="POST">
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
        <script type="module" src="js/components/addCapacityProduct.js"></script>';
} else if ($_GET["view"] == "change-product" && !empty($_GET["id"])) {
    echo '
<div class="main-form">
    <div class="form-container container__detail__product">
        <h1 class="form-title">Cập nhật thông tin sản phẩm</h1>
        <form id="form-change-product" enctype="multipart/form-data" method="POST">
                
        </form>
    </div>
</div>
<script type="module" src="js/components/changeProduct.js"></script>';
}
?>