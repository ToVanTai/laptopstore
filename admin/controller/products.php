<?php
include_once __DIR__."/../../utils/index.php";
Session::init();
    $method = $_SERVER["REQUEST_METHOD"];
    if($method=="GET" && empty($_GET["id"])){//call api
        middleware(
            function() {
                getProducts();
            }, false
        );
        die();
    }

    function getProducts(){
        $query='select id, background, model, screen, RAM, hardware, OS, CPU, VGA,warranty,discount, color from products ORDER BY created_at DESC';
        $dataRes=executeResult($query);
        echo json_encode($dataRes);
        http_response_code(200);
        
    }
