<?php
include_once __DIR__."/../../utils/index.php";
Session::init();


$method = $_SERVER["REQUEST_METHOD"];
if($method == "GET"){
    middleware(
        function() {
            getStatus();
        }, false
    );
}
function getStatus(){
    $query = "select id, name from status";
    $dataRes = executeResult($query);
    echo json_encode($dataRes);
    http_response_code(200);
}
?>