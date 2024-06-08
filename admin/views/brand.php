<!-- them moi/sua/lay ra -->
<?php
include_once __DIR__."/../../utils/index.php";

//change-brand&id=6
//new-brand//khong co id

$mode = !empty($_GET["view"]) ? $_GET["view"] : "";
switch ($mode) {
    case "new-brand":
        echo '
        <div class="main-form">
            <div class="form-container">
                <h1 class="form-title">Thêm mới hãng sản xuất</h1>
                <form enctype="multipart/form-data" id="form-add-brand" method="POST">
                    <div class="main-user-info">
                        <div class="user-input-box">
                            <label for="name">Tên hãng</label>
                            <input type="text" required name="name" id="name" placeholder="Nhập tên hãng">
                        </div>
                        <div class="user-input-box">
                            <label for="image">Ảnh nền</label>
                            <input type="file" name="image" required id="image" placeholder="Ảnh nền">
                        </div>
                        <button type="submit" class="btn">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
            <script type="module" src="js/components/addBrand.js"></script>';
        break;
    case "change-brand":
            echo '
            <div class="main-form">
                <div class="form-container">
                    <h1 class="form-title">Sửa hãng sản xuất</h1>
                    <form enctype="multipart/form-data" id="form-change-brand" method="POST">
                        <div class="main-user-info">
                            <div class="user-input-box">
                                <label for="name">Tên hãng</label>
                                <input type="text" required name="name" value="" id="name" placeholder="Nhập tên hãng">
                            </div>
                            <img style="height: 50px; object-fit:cover; margin-top:15px" id="image" src="" />
                            <div class="user-input-box">
                                <label for="image">Ảnh nền</label>
                                <input type="file" name="image" id="image" placeholder="Ảnh nền">
                            </div>
                            <button type="submit" class="btn">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
            <script type="module" src="js/components/changeBrand.js"></script>';
        break;
}

?>
