<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header('Access-Control-Allow-Headers: Content-Type, access-token, refresh-token');
header("Access-Control-Allow-Credentials: true");
include_once __DIR__."/../utils/index.php";
Session::init();


// Session::init();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    middleware(
        function() {
            readAll();
        }, false
    );
    Session::destroy();//nguy hiểm
}
function readAll(){
    $query = 'select id, name, image from brands';
    $queryResult = executeResult($query);
    $count = count($queryResult);
    $dataRes = array("count"=>$count,"data"=>$queryResult);
    echo json_encode($dataRes);
}
?>

