<?php
    include_once __DIR__."/../utils/index.php";
    Session::init();
    
    
    //dữ liệu được gửi toàn bộ từ form\
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        middleware(
            function() {
                check();
            }, false
        );
        die();
    }
    function check(){
        $dataRes = false;
        if(!empty(Session::get("user"))){
            $dataRes = array("user"=>Session::get("user"),"carts"=>Session::get("carts"));
            echo json_encode($dataRes);
            http_response_code(200);
        }else {
            echo $dataRes;
            http_response_code(203);
        }
    }
?>