<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
include_once "../../db/config.php";
include_once "../../utils/dbhelper.php";
include_once "../../utils/session.php";
include_once "../../utils/validate.php";
if (empty(Session::get("user")["role"])||Session::get("user")["role"]!=2) {
    http_response_code(203);
    echo "Bạn không là người quản trị.";
    die();
}
$method = $_SERVER["REQUEST_METHOD"];
if($method == "GET"){
    $statusId = getGET("status-id");
    $query = "select orders.id as orderId, status.name as statusName, orders.created_at as createAt, orders.updated_at as updatedAt from orders inner join status on orders.status_id = status.id  where status.id = '".$statusId."'";
    $dataMain = executeResult($query);
    echo json_encode($dataMain);
    http_response_code(200);
}
?>