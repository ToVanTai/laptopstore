<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
    header('Access-Control-Allow-Headers: Content-Type, access-token, refresh-token');
    header("Access-Control-Allow-Credentials: true");
    include_once __DIR__."/../utils/index.php";
    Session::init();
    

    //dữ liệu được gửi toàn bộ từ form\
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        middleware(
            function() {
                check();
            }
        );
        die();
    }
    function check(){
        $dataRes = false;

        if(!empty(Session::get("user_id"))){
            if (empty(Session::get("carts"))) {
                Session::set("carts", array());
            };
            if (empty(Session::get("user"))) {
                Session::set("user", array());
            };
            $dataRes = array("user"=>Session::get("user"),"carts"=>Session::get("carts"));
            echo json_encode($dataRes);
            http_response_code(200);
        }else {
            echo $dataRes;
            http_response_code(203);
        }
    }
?>