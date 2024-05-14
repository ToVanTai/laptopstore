<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header('Access-Control-Allow-Headers: Content-Type, access-token, refresh-token');
header("Access-Control-Allow-Credentials: true");
include_once __DIR__."/../utils/index.php";
Session::init();
//phần model
include __DIR__ . "/../model/index.php";
//phần enum
include_once __DIR__ . "/../enum/index.php";
use laptopstore\enum\{StatusCodeResponse};

//định dạng format cart là 


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    middleware(
        function() {
            getCart();
        }
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_GET['crud_req']) ) {
    middleware(
        function() {
            addToCart();
        }
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['crud_req'] == "updateCarts" ) {//change patch to post
    middleware(
        function() {
            updateCarts();
        }
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['crud_req'] == "deleteCarts" ) {//change delete to post
    middleware(
        function() {
            deleteCart();
        }
    );
    die();
}
function getCart(){
    echo json_encode(Session::get("carts"));
    http_response_code(StatusCodeResponse::OK);
}
/**
 * Thêm vào giỏ hàng
 */
function addToCart(){
    try{
        $cartKey = sprintf(strCarts, Session::get("user_id"));
        $productId=getGET("product_id");//mã sản phẩm cần thêm
        $capacityId=getGET("capacity_id");//mã dung lượng cần thêm
        $quantity=getGET("quantity");//số lượng cần thêm
        $dataBody = json_decode(file_get_contents("php://input"),true);//các thông tin của cart(giá, tên, đã được tính toán sẵn trước khi gửi lên đây)
        //validate
        if($productId==null||$capacityId==null||$quantity==null){
            http_response_code(StatusCodeResponse::NonAuthoritativeInformation);
            echo "Yêu cầu có mã sản phẩm, mã dung lượng, số lượng.";
            die();
        }
        //thêm vào session carts
        $carts=RedisService::getCarts($cartKey);
        //nếu session trống thì thêm luôn
        if(count($carts)==0){
            $cartAdd=array("productId"=>$productId,
            "capacityId"=>$capacityId,
            "quantity"=>$quantity,
            "detail"=>$dataBody
            );
            array_unshift($carts,$cartAdd);
            RedisService::updateCarts($cartKey, $carts);
            http_response_code(StatusCodeResponse::Created);
            echo json_encode($carts);
            die();
        };
        //nếu giở hàng không trống
        if(count($carts)>=1){
            $isAddNew=true;
            $quantityOld=0;
            $indexAddNew=0;
            //kiểm tra trùng mã và trùng id
            foreach($carts as $cart){
                if($cart["productId"]==$productId&&$cart["capacityId"]==$capacityId){
                    $isAddNew=false;
                    $quantityOld=$cart["quantity"];//TH1: đã tồn tại trong giỏ hàng => update quantity
                    break;
                }else{
                    $indexAddNew++;//TH2: chưa tồn tại trong giỏ hàng => thêm vào đầu mảng
                }
            }  
            if($isAddNew==false){//TH1
                $quantity=(int)$quantity+(int)$quantityOld;
                $carts[$indexAddNew]["quantity"]=$quantity;
                RedisService::updateCarts($cartKey, $carts);
                http_response_code(StatusCodeResponse::OK);
                echo json_encode($carts);
                die();
            }//TH2
            if($isAddNew==true){ 
                $cartAdd=array("productId"=>$productId,
                "capacityId"=>$capacityId,
                "quantity"=>$quantity,
                "detail"=>$dataBody
                );
                array_unshift($carts,$cartAdd);
                RedisService::updateCarts($cartKey, $carts);
                http_response_code(StatusCodeResponse::Created);
                echo json_encode($carts);
                die();   
            }
        }
    }catch(Exception $e){
        // Xử lý ngoại lệ đã xảy ra
        echo "Có lỗi xảy ra: " . $e->getMessage();
    }
};
function updateCarts(){
    $dataBody = json_decode(file_get_contents("php://input"),true);
    $cartKey = sprintf(strCarts, Session::get("user_id"));
    RedisService::updateCarts($cartKey, $dataBody);
    http_response_code(StatusCodeResponse::Created);
    echo json_encode( $dataBody);
};
function deleteCart(){
    $cartKey = sprintf(strCarts, Session::get("user_id"));
    RedisService::updateCarts($cartKey, array());
    echo "xoa cart";
};
