<?php
$view = "home";
if (!empty($_GET["view"])) {
    $view = $_GET["view"];
}
switch ($view) {
    case "product":
        include "./views/header.php";
        include "./views/product.php";
        include "./views/footer.php";
        break;
    case "carts":
        include_once __DIR__."/utils/index.php";
        Session::init();
        if(empty(Session::get("user_id"))){
            echo '<script>
                alert("Vui lòng đăng nhập để sử dụng chức năng này.");
                window.location.href="'.baseUrl.'";
            </script>';
        }else{
            include "./views/header.php";
            include "./views/carts.php";
            include "./views/footer.php";
        }
        break;
    case "home":
        include "./views/header.php";
        include "./views/products.php";
        include "./views/footer.php";
        break;
    case "purchased":
        include_once __DIR__."/utils/index.php";
        Session::init();
        if(empty(Session::get("user_id"))){
            echo '<script>
                alert("Vui lòng đăng nhập để sử dụng chức năng này.");
                window.location.href="'.baseUrl.'";
            </script>';
        }else{
            include "./views/header.php";
            include "./views/purchased.php";
            include "./views/footer.php";
        }
        break;
    default:
        include "./views/header.php";
        include "./views/products.php";
        include "./views/footer.php";
        break;
}
