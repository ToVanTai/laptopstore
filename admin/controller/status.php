<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
include_once "../../db/config.php";
include_once "../../utils/dbhelper.php";
include_once "../../utils/session.php";
include_once "../../utils/validate.php";
$method = $_SERVER["REQUEST_METHOD"];
if($method == "GET"){
    $query = "select id, name from status";
    $dataRes = executeResult($query);
    echo json_encode($dataRes);
    http_response_code(200);
}
?>