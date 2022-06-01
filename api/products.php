<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
include_once "../classes/Product.php";
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
Session::init();
$page = getGET("page")==null?1:getGET("page");//trang hiển thị
$search = getGET("search");//từ khóa tìm kiếm
$categoryName = getGET("category-name");//tên thể loại
$id = getGET("id");//sản phâm duy nhất
$limit = getGET("limit")==null?8:getGET("limit");

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $id!=null) {
    //lay theo id
    echo "id";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $search == null && $categoryName == null && $id==null) {
    //san pham theo page
    echo "theo page";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $id==null && $search != null && $categoryName==null) {
    //tim kiem san pham theo ten+page
    echo "theo ten";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "GET"&& $id==null && $search == null && $categoryName!=null) {
    //tim kiem san pham theo the loai+age
    echo "theo the loai";
    die();
}
?>

