<?php
include_once __DIR__."/../utils/index.php";
Session::init();
//phần model
include __DIR__ . "/../model/index.php";
use laptopstore\model\{Cart};
//phần enum
include __DIR__ . "/../enum/index.php";
use laptopstore\enum\{StatusCodeResponse};
$http_origin = "";
if (!empty($_SERVER['HTTP_ORIGIN'])) {
    if (in_array($_SERVER['HTTP_ORIGIN'], allowedOrigins)) {
        $http_origin = $_SERVER['HTTP_ORIGIN'];
    }
}
header("Access-Control-Allow-Origin: " . $http_origin);
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

if(empty(Session::get("user"))){
    http_response_code(StatusCodeResponse::Unauthorized);
    echo "Yêu cầu đăng nhập để thực hiện chức năng này.";
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //lay toan bo cart
    getCart();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_GET['crud_req']) ) {
    addToCart();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['crud_req'] == "updateCarts" ) {//change patch to post
    //cap nhat carts
    updateCarts();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['crud_req'] == "deleteCarts" ) {//change delete to post
    //xoa cart
    deleteCart();
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
        $carts=Session::get("carts");
        //nếu session trống thì thêm luôn
        if(count($carts)==0){
            $cartAdd=array("productId"=>$productId,
            "capacityId"=>$capacityId,
            "quantity"=>$quantity,
            "detail"=>$dataBody
            );
            array_unshift($carts,$cartAdd);
            Session::set("carts",$carts);
            http_response_code(StatusCodeResponse::Created);
            echo json_encode(Session::get("carts"));
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
                Session::set("carts",$carts);
                http_response_code(StatusCodeResponse::OK);
                echo json_encode(Session::get("carts"));
                die();
            }//TH2
            if($isAddNew==true){ 
                $cartAdd=array("productId"=>$productId,
                "capacityId"=>$capacityId,
                "quantity"=>$quantity,
                "detail"=>$dataBody
                );
                array_unshift($carts,$cartAdd);
                Session::set("carts",$carts);
                http_response_code(StatusCodeResponse::Created);
                echo json_encode(Session::get("carts"));
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
    Session::set("carts",$dataBody);
    http_response_code(StatusCodeResponse::Created);
    echo json_encode( Session::get("carts"));
};
function deleteCart(){
    echo "xoa cart";
};
