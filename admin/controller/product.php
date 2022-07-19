<?php
include_once "../../db/config.php";
include_once "../../utils/dbhelper.php";
include_once "../../utils/session.php";
include_once "../../utils/validate.php";
$http_origin = "";
if (!empty($_SERVER['HTTP_ORIGIN'])) {
    if (in_array($_SERVER['HTTP_ORIGIN'], allowedOrigins)) {
        $http_origin = $_SERVER['HTTP_ORIGIN'];
    }
}

header("Access-Control-Allow-Origin: " . $http_origin);
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");

$method = $_SERVER["REQUEST_METHOD"];
Session::init();
if ($method == "POST" && !empty($_POST["crud_request"]) && $_POST["crud_request"] == "add-newproduct") {
    addNewProduct();
    die();
}
if ($method == "POST" && !empty($_POST["crud_request"]) && $_POST["crud_request"] == "change-capacity-product" && !empty($_GET["id"])) {
    changeCapacityProduct();
    die();
}
if ($method == "POST" && !empty($_POST["crud_request"]) && $_POST["crud_request"] == "add-capacity-product" && !empty($_GET["id-product"])) {
    addCapacityProduct();
    die();
}
if ($method == "POST"  && !empty($_POST["crud_request"]) && $_POST["crud_request"] == "change-product" && !empty($_GET["id"])) {
    changeProduct();
}


function addNewProduct()
{
    $isValidate = true;
    $brand_id = getPOST("brand_id");
    $model = getPOST("model");
    $screen = getPOST("screen");
    $RAM = getPOST("RAM");
    $hardware = getPOST("hardware");
    $OS = getPOST("OS");
    $CPU = getPOST("CPU");
    $VGA = getPOST("VGA");
    $warranty = getPOST("warranty");
    $discount = getPOST("discount"); //*
    $color = getPOST("color");
    $capacity_name = getPOST("capacity_name");
    $quantity = getPOST("quantity"); //*
    $price = getPOST("price"); //*
    $errMessage = "";
    $regDiscount = "/^[0-9]{0,2}$/";//0->
    $regPrice = "/^[0-9]{1,}$/";//
    $regQuantity = "/^[0-9]{0,}$/";//
    $files = !empty($_FILES["background"]["name"]) ? $_FILES["background"] : null;
    if ($files == null || $brand_id == null || $model == null || $screen == null || $RAM == null || $hardware == null || $OS == null || $CPU == null || $VGA == null || $warranty == null || $color == null || $capacity_name == null) {
        $errMessage = "Vui lòng điền đầy đủ các trường. ";
        $isValidate = false;
    }
    if (!preg_match($regDiscount, $discount)) {
        $isValidate = false;
        $errMessage = $errMessage . "Giảm giá chưa đúng định dạng. ";
    }
    if (!preg_match($regQuantity, $quantity)) {
        $isValidate = false;
        $errMessage = $errMessage . "Số lượng chưa đúng định dạng. ";
    }
    if (!preg_match($regPrice, $price)) {
        $isValidate = false;
        $errMessage = $errMessage . "Giá chưa đúng định dạng. ";
    }
    if ($files != null && validateFile($files) != "") {
        $isValidate = false;
        $errMessage = $errMessage . validateFile($files);
    }
    if ($isValidate == false) {
        echo $errMessage;
        echo "<script>
                alert('Thêm thất bại do " . $errMessage . "');
            </script>";
        echo "<a href='../index.php?view=new-product'>về trang thêm</a>";
    } else {
        $nameFile = time() . $files["name"];
        $from = $files["tmp_name"];
        $to = "../../store/" . $nameFile;
        $created_at = $updated_at = date("Y-m-d h:i:s");
        $created_by = Session::get("user")["id"];
        $role = Session::get("user")["role"];
        if ($role == 2) {
            if (move_uploaded_file($from, $to)) {
                $query =  "INSERT INTO `products` (`brand_id`, `model`, `screen`, `RAM`, `hardware`, `OS`,
                `CPU`, `VGA`, `background`, `warranty`, `discount`, `color`, `created_by`,
                `created_at`, `updated_at`)
                VALUES ('" . $brand_id . "', '" . $model . "', '" . $screen . "', '" . $RAM . "','" . $hardware . "','" . $OS . "', 
                '" . $CPU . "', '" . $VGA . "', '" . $nameFile . "', '" . $warranty . "', '" . $discount . "', '" . $color . "', 
                '" . $created_by . "', '" . $created_at . "', '" . $updated_at . "');";
                execute($query);
                $query = "select id from products where created_by = '" . $created_by . "' and background = '" . $nameFile . "' limit 1 ;";
                $idNewProduct = executeResult($query)[0]["id"];
                if (!empty($idNewProduct)) {
                    $query = "INSERT INTO `product_capacities` 
                    (`product_id`, `capacity_name`, `price`, `quantity`) VALUES 
                    ('" . $idNewProduct . "', '" . $capacity_name . "', '" . $price . "', '" . $quantity . "');";
                    execute($query);
                    echo "<script>
                        alert('Thêm thành công');
                    </script>";
                    echo "<a href='../index.php?view=new-product'>về trang thêm</a>";
                } else {
                    echo "<script>
                        alert('Thêm thất bại');
                    </script>";
                    echo "<a href='../index.php?view=new-product'>về trang thêm</a>";
                }
            }
        }
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
        echo $errMessage;
        echo "<script>
                alert('Cập nhât bại do " . $errMessage . "');
            </script>";
        echo "<a href='../index.php'>về trang chủ</a>";
    } else {
        $role = Session::get("user")["role"];
        if ($role == 2) {
            $query = "UPDATE product_capacities SET capacity_name='" . $capacity_name . "',
            price='" . $price . "', quantity='" . $quantity . "'
            WHERE id='" . $_GET["id"] . "'";
            execute($query);
            echo "<script>
                        alert('Cập nhât thành công');
                    </script>";
        }
    }
}
function addCapacityProduct()
{
    $idProduct = $_GET["id-product"];
    $query = "select model from products where id = " . $idProduct . " limit 1";
    if (count(executeResult($query)) < 1) {
        echo "<script>
                alert('Không tồn tại mã sản phẩm');
            </script>";
        echo "<a href='../index.php'>về chủ</a>";
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
            echo $errMessage;
            echo "<script>
                alert('Thêm thất bại do " . $errMessage . "');
            </script>";
            echo "<a href='../index.php'>về chủ</a>";
        } else {
            $role = Session::get("user")["role"];
            if ($role == 2) {
                $query = "INSERT INTO `product_capacities` 
                    (`product_id`, `capacity_name`, `price`, `quantity`) VALUES 
                    ('" . $idProduct . "', '" . $capacity_name . "', '" . $price . "', '" . $quantity . "');";
                execute($query);
                echo "<script>
                        alert('Thêm thành công');
                    </script>";
                echo "<a href='../index.php>về trang chủ</a>";
            }
        }
    }
}
function changeProduct()
{
    $role = Session::get("user")["role"];
    if ($role == 2) {
        $id = getGET("id");
        $isValidate = true;
        $brand_id = getPOST("brand_id");
        $model = getPOST("model");
        $screen = getPOST("screen");
        $RAM = getPOST("RAM");
        $hardware = getPOST("hardware");
        $OS = getPOST("OS");
        $CPU = getPOST("CPU");
        $VGA = getPOST("VGA");
        $warranty = getPOST("warranty");
        $discount = getPOST("discount"); //*
        $color = getPOST("color");
        $errMessage = "";
        $regDiscount = "/^[0-9]{0,2}$/";
        $files = !empty($_FILES["background"]["name"]) ? $_FILES["background"] : null;
        if ($brand_id == null || $model == null || $screen == null || $RAM == null || $hardware == null || $OS == null || $CPU == null || $VGA == null || $warranty == null || $color == null) {
            $errMessage = "Vui lòng điền đầy đủ các trường. ";
            $isValidate = false;
        }
        if (!preg_match($regDiscount, $discount)) {
            $isValidate = false;
            $errMessage = $errMessage . "Giảm giá chưa đúng định dạng. ";
        }
        if ($files != null && validateFile($files) != "") {
            $isValidate = false;
            $errMessage = $errMessage . validateFile($files);
        }
        if ($isValidate == false) {
            echo $errMessage;
            echo "<script>
                alert('Cập nhật thất bại do " . $errMessage . "');
            </script>";
            echo "<a href='../index.php'>về trang chủ</a>";
        } else {
            if ($files == null) {
                $updated_at = date("Y-m-d h:i:s");
                $query = "UPDATE `products` SET 
            `brand_id` = '" . $brand_id . "', `model` = '" . $model . "', `screen` = '" . $screen . "', 
            `RAM` = '" . $RAM . "', `hardware` = '" . $hardware . "', `OS` = '" . $OS . "', `CPU` = '" . $CPU . "', 
            `VGA` = '" . $VGA . "', `warranty` = '" . $warranty . "', `updated_at` = '". $updated_at ."'  WHERE `products`.`id` = '" . $id . "'";
                execute($query);
                echo "<script>
                alert('Cập nhật thành công.');
            </script>";
            } else {
                $query = "select background from products where id = ".$id." ";
                $queryResult = executeResult($query); 
                $background = count($queryResult)>=1?$queryResult[0]["background"]:null;
                if($background!=null){
                    unlink("../../store/".$background);
                };
                $nameFile = time() . $files["name"];
                $from = $files["tmp_name"];
                $to = "../../store/" . $nameFile;
                $updated_at = date("Y-m-d h:i:s");
                if (move_uploaded_file($from, $to)) {
                    $query = "UPDATE `products` SET 
                    `brand_id` = '" . $brand_id . "', `model` = '" . $model . "', `screen` = '" . $screen . "', 
                    `RAM` = '" . $RAM . "', `hardware` = '" . $hardware . "', `OS` = '" . $OS . "', `CPU` = '" . $CPU . "', 
                    `VGA` = '" . $VGA . "', `warranty` = '" . $warranty . "', `background` = '" . $nameFile . "', `updated_at` = '". $updated_at ."'  WHERE `products`.`id` = '" . $id . "'";
                        execute($query);
                        echo "<script>
                        alert('Cập nhật thành công.');
                    </script>";
                }
            }
        }
    }
}
