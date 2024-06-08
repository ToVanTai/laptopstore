<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header('Access-Control-Allow-Headers: Content-Type, access-token, refresh-token');
header("Access-Control-Allow-Credentials: true");
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
        function() use($id) {
            Product::readItem($id);
        }, false
    );
    Session::destroy();//nguy hiểm
    //lay theo id products.php?id=1
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $search == null && $categoryName == null && $id==null) {
    middleware(
        function() use($page, $limit) {
            Product::readPage($page, $limit, null, null);
        }, false
    );
    Session::destroy();//nguy hiểm
    //san pham theo page products.php?page=1&limit=8
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && $search != null) {
    middleware(
        function() use($page, $limit, $search){
            Product::readPage($page, $limit, $search, null);
        }, false
    );
    Session::destroy();//nguy hiểm
    //tim kiem san pham theo ten+page products.php?search=xr&limit=8&page=1
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $categoryName!=null) {
    middleware(
        function() use ($page, $limit, $categoryName){
            Product::readPage($page, $limit, null, $categoryName);
        }, false
    );
    Session::destroy();//nguy hiểm
    //tim kiem san pham theo the loai+age  products.php?category-name=xr&limit=8&page=1
    die();
}

?>

