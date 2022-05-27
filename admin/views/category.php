<!-- them moi/sua/lay ra -->
<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";

//change-category&id=6
//new-category//khong co id

$mode = !empty($_GET["view"]) ? $_GET["view"] : "";
switch ($mode) {
    case "new-category":
        echo '
                <div class="container__detail__product">
                <form enctype="multipart/form-data" action="controller/categories.php" method="POST">
                    <label for="name">Tên hãng</label>
                    <input type="text" required name="name" id="name" placeholder="Nhập tên hãng">
                    <label for="image">Ảnh nền</label>
                    <input type="file" name="image" required id="image" placeholder="Ảnh nền">
                    <button type="submit" class="btn">Lưu</button>
                </form>
            </div>';
        break;
    case "change-category":
        $id = getGET("id");
        if ($id != null) {
            $query = 'select * from categories where id = ' . $id . ' limit 1';
            $resData = executeResult($query,true);
            $name = $resData["name"];
            $image = baseUrl."store/".$resData["image"];
            echo '
                <div class="container__detail__product">
                <form enctype="multipart/form-data" action="controller/categories.php?id='.$id.'" method="POST">
                    <label for="name">Tên hãng</label>
                    <input type="text" required name="name" value="'.$name.'" id="name" placeholder="Nhập tên hãng">
                    <img style="height: 50px; object-fit:cover; margin-top:15px" src="'.$image.'" />
                    <label for="image">Ảnh nền</label>
                    <input type="file" name="image" id="image" placeholder="Ảnh nền">
                    <button type="submit" class="btn">Lưu</button>
                </form>
            </div>';
        }

        break;
}

?>
<!-- <div class="container__detail__product">
        <form action="">
            <label for="name">Tên danh mục</label>
            <input type="text" name="name" id="name" placeholder="Nhập tên danh mục">
            <button type="submit" class="btn">Lưu</button>
        </form>
    </div> -->