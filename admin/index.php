<?php
include_once "../utils/session.php";
$user = Session::get("user");
if (empty($user)) {
    echo "<script>alert('Bạn chưa đăng nhập')</script>";
    echo "<a href='../index.php'>về trang chủ</a>";
} else {
    $role = $user["role"];
    if ($role == 1) {
        echo "<script>alert('Bạn không có quyền truy cập')</script>";
        echo "<a href='../index.php'>về trang chủ</a>";
    } else {
        $view = "products";
        if (!empty($_GET["view"])) {
            $view = $_GET["view"];
        };
        if ($view == "product" || $view == "change-product" || $view == "new-product") {
            $view = "product";
        }
        if ($view == "category" || $view == "change-category" || $view == "new-category") {
            $view = "category";
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
            case "categories":
                include "./views/header.php";
                include "./views/categories.php";
                include "./views/footer.php";
                break;
            case "product":
                include "./views/header.php";
                include "./views/product.php";
                include "./views/footer.php";
                break;
            case "category":
                include "./views/header.php";
                include "./views/category.php";
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
