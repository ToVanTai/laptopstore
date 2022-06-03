<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
Session::init();//Session::set("carts"=>array());
if(empty(Session::get("user"))){
    http_response_code(203);
    echo "Yêu cầu đăng nhập để thực hiện chức năng này.";
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //lay toan bo cart
    getCart();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    //them vao cart
    addToCart();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "PATCH" ) {
    //thay doi so luong
    changeToCart();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "DELETE" ) {
    //xoa cart
    deleteCart();
    die();
}
function getCart(){
    echo json_encode(Session::get("carts"));
    http_response_code(200);
}
function addToCart(){
    $productId=getGET("product_id");
    $capacityId=getGET("capacity_id");
    $quantity=getGET("quantity");
    $dataBody = json_decode(file_get_contents("php://input"),true);
    if($productId==null||$capacityId==null||$quantity==null){
        http_response_code(203);
        echo "Yêu cầu có mã sản phẩm, mã dung lượng, số lượng.";
        die();
    }
    $carts=Session::get("carts");
    if(count($carts)==0){
        $cartAdd=array("productId"=>$productId,
        "capacityId"=>$capacityId,
        "quantity"=>$quantity,
        "detail"=>$dataBody
        );
        array_unshift($carts,$cartAdd);
        Session::set("carts",$carts);
        http_response_code(200);
        echo json_encode(Session::get("carts"));
        die();
    };
    if(count($carts)>=1){
        $isAddNew=true;
        $quantityOld=0;
        $indexAddNew=0;
        foreach($carts as $cart){
            if($cart["productId"]==$productId&&$cart["capacityId"]==$capacityId){
                $isAddNew=false;
                $quantityOld=$cart["quantity"];
                break;
            }else{
                $indexAddNew++;
            }
            }  
        if($isAddNew==false){
            $quantity=(int)$quantity+(int)$quantityOld;
            $carts[$indexAddNew]["quantity"]=$quantity;
            Session::set("carts",$carts);
            http_response_code(200);
            echo json_encode(Session::get("carts"));
            die();
        }
        if($isAddNew==true){
            $cartAdd=array("productId"=>$productId,
            "capacityId"=>$capacityId,
            "quantity"=>$quantity,
            "detail"=>$dataBody
            );
            array_unshift($carts,$cartAdd);
            Session::set("carts",$carts);
            http_response_code(200);
            echo json_encode(Session::get("carts"));
            die();   
        }
    }
    
};
function changeToCart(){
    echo "thay doi so luong";
};
function deleteCart(){
    echo "xoa cart";
};
