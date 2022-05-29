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
        include "./views/header.php";
        include "./views/carts.php";
        include "./views/footer.php";
        break;
    case "home":
        include "./views/header.php";
        include "./views/products.php";
        include "./views/footer.php";
        break;
    case "purchased":
        include "./views/header.php";
        include "./views/purchased.php";
        include "./views/footer.php";
        break;
    default:
        include "./views/header.php";
        include "./views/products.php";
        include "./views/footer.php";
        break;
}
