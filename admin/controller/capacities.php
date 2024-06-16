<?php
include_once __DIR__."/../../utils/index.php";
Session::init();

if (empty(Session::get("role_id"))||Session::get("role_id")!=2) {
    http_response_code(203);
    echo "Bạn không là người quản trị.";
    die();
}
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "GET" && !empty($_GET["product_id"])) {
    middleware(
        function() {
            getCapacities();
        }, false
    );
    die();
}
if ($method == "GET" && !empty($_GET["id"])) {
    middleware(
        function() {
            getCapacityProduct();
        }, false
    );
    die();
}
if ($method == "POST" && !empty($_GET["id"])) {
    middleware(
        function() {
            changeCapacityProduct();
        }, false
    );
    die();
}
if ($method == "POST" && !empty($_GET["id-product"])) {
    middleware(
        function() {
            addCapacityProduct();
        }, false
    );
    die();
}
function getCapacities(){
    $id = getGET("product_id");
    $query = 'select * from product_capacities where product_id = '.$id.';';
    $dataQueryCapacities = executeResult($query);
    echo json_encode($dataQueryCapacities);
}
function getCapacityProduct()
{
    $id = getGET("id");
    if ($id > 0) {
        $query = 'select * from product_capacities where id = ' . $id . ' limit 1;';
        $dataQueryCapacities = executeResult($query, true);
        echo json_encode($dataQueryCapacities);
    } else {
        http_response_code(203);
    }
}
function changeCapacityProduct()
{
    $isValidate = true;
    $capacity_name = getPOST("capacity_name");
    $quantity = getPOST("quantity"); //*
    $price = getPOST("price"); //*
    $errMessage = "";
    $regPrice = "/^[0-9]{1,}$/";
    $regQuantity = "/^[0-9]{0,}$/";
    if ($capacity_name == null) {
        $errMessage = "Vui lòng điền đầy đủ các trường. ";
        $isValidate = false;
    }
    if (!preg_match($regQuantity, $quantity)) {
        $isValidate = false;
        $errMessage = $errMessage . "Số lượng chưa đúng định dạng. ";
    }
    if (!preg_match($regPrice, $price)) {
        $isValidate = false;
        $errMessage = $errMessage . "Giá chưa đúng định dạng. ";
    }
    if ($isValidate == false) {
        echo 'Cập nhât bại do ' . $errMessage;
        http_response_code(203);
    } else {
        $role = Session::get("role_id");
        if ($role == 2) {
            $query = "UPDATE product_capacities SET capacity_name='" . $capacity_name . "',
            price='" . $price . "', quantity='" . $quantity . "'
            WHERE id='" . $_GET["id"] . "'";
            execute($query);
            echo "Cập nhât thành công')";
        }
    }
}
function addCapacityProduct()
{
    $idProduct = $_GET["id-product"];
    $query = "select model from products where id = " . $idProduct . " limit 1";
    if (count(executeResult($query)) < 1) {
        echo "Sản phẩm không tồn tại";
        http_response_code(203);
    } else {
        $isValidate = true;
        $capacity_name = getPOST("capacity_name");
        $quantity = getPOST("quantity"); //*
        $price = getPOST("price"); //*
        $errMessage = "";
        $regPrice = "/^[0-9]{1,}$/";
        $regQuantity = "/^[0-9]{0,}$/";
        if ($capacity_name == null) {
            $errMessage = "Vui lòng điền đầy đủ các trường. ";
            $isValidate = false;
        }
        if (!preg_match($regQuantity, $quantity)) {
            $isValidate = false;
            $errMessage = $errMessage . "Số lượng chưa đúng định dạng. ";
        }
        if (!preg_match($regPrice, $price)) {
            $isValidate = false;
            $errMessage = $errMessage . "Giá chưa đúng định dạng. ";
        }
        if ($isValidate == false) {
            echo "Thêm thất bại do " . $errMessage;
            http_response_code(203);
        } else {
            $role = Session::get("role_id");
            if ($role == 2) {
                $query = "INSERT INTO `product_capacities` 
                    (`product_id`, `capacity_name`, `price`, `quantity`) VALUES 
                    ('" . $idProduct . "', '" . $capacity_name . "', '" . $price . "', '" . $quantity . "');";
                execute($query);
                echo "Thêm thành công";
            }
        }
    }
}
?>