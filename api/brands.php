<?php
include_once __DIR__."/../utils/index.php";
Session::init();


// Session::init();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    middleware(
        function() {
            readAll();
        }
    );
}
function readAll(){
    $query = 'select id, name, image from brands';
    $queryResult = executeResult($query);
    $count = count($queryResult);
    $dataRes = array("count"=>$count,"data"=>$queryResult);
    echo json_encode($dataRes);
}
?>

