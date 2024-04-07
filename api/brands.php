<?php
include_once __DIR__."/../utils/index.php";
Session::init();

$http_origin = "";
if (!empty($_SERVER['HTTP_ORIGIN'])) {
    if (in_array($_SERVER['HTTP_ORIGIN'], allowedOrigins)) {
        $http_origin = $_SERVER['HTTP_ORIGIN'];
    }
}
header("Access-Control-Allow-Origin: " . $http_origin);
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
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

