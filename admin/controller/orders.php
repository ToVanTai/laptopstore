<?php
include_once "../../db/config.php";
include_once "../../utils/dbhelper.php";
include_once "../../utils/session.php";
include_once "../../utils/validate.php";
header("Access-Control-Allow-Origin: ".origin);
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");

if (empty(Session::get("user")["role"])||Session::get("user")["role"]!=2) {
    http_response_code(203);
    echo "Bạn không là người quản trị.";
    die();
}
$method = $_SERVER["REQUEST_METHOD"];
if($method == "GET" && !empty(getGET("id"))){
    $idOrder = getGET("id");
    $query = "select orders.id as orderId,status.id as statusId, status.name as statusName, 
    orders.created_at, orders.updated_at from orders inner join status on orders.status_id = status.id 
    where orders.id= ".$idOrder ." ;";
    $listDataMain = executeResult($query,true);
    if(empty($listDataMain["orderId"])){
        http_response_code(203);
        die();
    }
    $query='select order_details.order_id as orderId, order_details.product_id as productId, order_details.capacity_id as capacityId, order_details.quantity as quantity, order_details.price as price, 
    product_capacities.capacity_name as capacityName, products.model as model, products.background as background from
    order_details inner join product_capacities on order_details.capacity_id = product_capacities.id inner join
    products on product_capacities.product_id = products.id where order_details.order_id = "'.$listDataMain["orderId"].'" ;';
    $listDataDetail=executeResult($query);
    $listDataMain["orderDetails"]=$listDataDetail;
    echo json_encode($listDataMain);
    http_response_code(200);
    die();

}
if($method == "GET"){
    $statusId = getGET("status-id");
    $query = "select orders.id as orderId,status.id as statusId, status.name as statusName, orders.created_at as createAt, orders.updated_at as updatedAt from orders inner join status on orders.status_id = status.id  where status.id = '".$statusId."' 
    ORDER BY orders.created_at DESC";
    $dataMain = executeResult($query);
    echo json_encode($dataMain);
    http_response_code(200);
    die();
}
if($method == "PATCH"){
    //chỉ dành cho người quản tri
    $dataBody = json_decode(file_get_contents("php://input"),true);
    if(empty($dataBody["statusChange"])||empty($dataBody["orderId"])){
        echo "Cập nhật thất bại!";
        http_response_code(203);
        die();
    }
    $query='update orders set status_id = "'.$dataBody["statusChange"].'" where id = "'.$dataBody["orderId"].'"  ;';
    execute($query);
    http_response_code(201);
}
?>