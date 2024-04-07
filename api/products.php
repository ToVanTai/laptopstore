<?php
include_once __DIR__."/../utils/index.php";
Session::init();
include_once "../classes/Product.php";

$page = getGET("page")==null?1:getGET("page");//trang hiển thị
$search = getGET("search");//từ khóa tìm kiếm
$categoryName = getGET("category-name");//tên thể loại
$id = getGET("id");//sản phâm duy nhất
$limit = getGET("limit")==null?8:getGET("limit");

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $id!=null) {
    middleware(
        function() {
            Product::readItem($id);
        }
    );
    //lay theo id products.php?id=1
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $search == null && $categoryName == null && $id==null) {
    middleware(
        function() {
            Product::readPage($page, $limit, null, null);
        }
    );
    //san pham theo page products.php?page=1&limit=8
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && $search != null) {
    middleware(
        function() {
            Product::readPage($page, $limit, $search, null);
        }
    );
    //tim kiem san pham theo ten+page products.php?search=xr&limit=8&page=1
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $categoryName!=null) {
    middleware(
        function() {
            Product::readPage($page, $limit, null, $categoryName);
        }
    );
    //tim kiem san pham theo the loai+age  products.php?category-name=xr&limit=8&page=1
    die();
}

?>

