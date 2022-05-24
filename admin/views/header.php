<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan ly san pham</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="header__title">
            <a  href="index.php">ADMIN</a>
        </div>
        <?php
            $viewMode = isset($_GET["view"])?$_GET["view"]:"products";
            if ($viewMode == "products"||$viewMode == "product" || $viewMode == "change-product" || $viewMode == "new-product") {
                $viewMode = "product";
            }elseif($viewMode == "categories"||$viewMode == "category" || $viewMode == "change-category" || $viewMode == "new-category"){
                $viewMode = "category";
            }else{
                $viewMode = "cart";
            }
        ?>
        <div class="header__list__link">
            <a href="index.php" class="header__link <?= $viewMode=="product"?"active":"" ?>">quản lý sản phẩm</a>
            <a href="index.php?view=categories" class="header__link <?= $viewMode=="category"?"active":"" ?>" >quản lý danh mục</a>
            <a href="index.php?view=carts" class="header__link <?= $viewMode=="cart"?"active":"" ?>">quản lý đơn hàng</a>
        </div>
    </header>