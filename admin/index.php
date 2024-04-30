<?php
include_once __DIR__."/../utils/index.php";
Session::init();
$userID = Session::get("user_id");
$roleID = Session::get("role_id");
if (empty($user)) {
    echo "<script>alert('Bạn chưa đăng nhập')</script>";
    echo "<a href='../index.php'>về trang chủ</a>";
} else {
    if ($roleID == 1) {
        echo "<script>alert('Bạn không có quyền truy cập')</script>";
        echo "<a href='../index.php'>về trang chủ</a>";
    } else if ($roleID == 2) {
        $view = "products";
        if (!empty($_GET["view"])) {
            $view = $_GET["view"];
        };
        if ($view == "product" || $view == "change-product" || $view == "new-product" || $view == "change-capacity-product" || $view == "add-capacity-product") {
            $view = "product";
        }
        if ($view == "brand" || $view == "change-brand" || $view == "new-brand") {
            $view = "brand";
        }
        switch ($view) {
            case "products":
                include "./views/header.php";
                include "./views/products.php";
                include "./views/footer.php";
                break;
            case "carts":
                include "./views/header.php";
                include "./views/carts.php";
                include "./views/footer.php";
                break;
            case "cart":
                include "./views/header.php";
                include "./views/cart.php";
                include "./views/footer.php";
                break;
            case "brands":
                include "./views/header.php";
                include "./views/brands.php";
                include "./views/footer.php";
                break;
            case "product":
                include "./views/header.php";
                include "./views/product.php";
                include "./views/footer.php";
                break;
            case "brand":
                include "./views/header.php";
                include "./views/brand.php";
                include "./views/footer.php";
                break;
            default:
                include "./views/header.php";
                include "./views/products.php";
                include "./views/footer.php";
                break;
        }
    }
}
