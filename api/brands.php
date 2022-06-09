<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
header("Access-Control-Allow-Origin: ".origin);
header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Credentials: true");
// Session::init();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    readAll();
}
function readAll(){
    $query = 'select id, name, image from brands';
    $queryResult = executeResult($query);
    $count = count($queryResult);
    $dataRes = array("count"=>$count,"data"=>$queryResult);
    echo json_encode($dataRes);
}
?>

