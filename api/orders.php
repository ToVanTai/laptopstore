<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
Session::init(); //Session::set("carts"=>array());
if (empty(Session::get("user"))) {
    http_response_code(203);
    echo "Yêu cầu đăng nhập để thực hiện chức năng này.";
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //yêu cầu đặt hàng.
    addToOrders();
    die();
}
function addToOrders()
{
    $carts = Session::get("carts");
    if (count($carts) <= 0) {
        http_response_code(203);
        echo "Giỏ hàng trống!";
    } else {

        $idUser = Session::get("user")["id"];
        $query = 'select name, phone_number, address, email from users where id = ' . $idUser . ' ;';
        $aboutUser = executeResult($query, true);
        if (empty($aboutUser["name"]) || empty($aboutUser["phone_number"]) || empty($aboutUser["address"]) || empty($aboutUser["email"])) {
            http_response_code(203);
            echo "Vui lòng cập nhật thông tin họ tên, số điện thoại, địa chỉ, email.";
        } else {
            $idStatus = 1;
            $createdAt = date("Y-m-d h:i:s");
            $updatedAt = date("Y-m-d h:i:s");
            $query = 'insert into orders(user_id,status_id,created_at,updated_at)
            values("' . $idUser . '", "' . $idStatus . '", "' . $createdAt . '", "' . $updatedAt . '") ;';
            execute($query);
            $query = 'select id from orders where user_id = "' . $idUser . '" and status_id= "' . $idStatus . '"
            and created_at= "' . $createdAt . '" and updated_at = "' . $updatedAt . '" limit 1 ;';
            $idOrder = executeResult($query, true)["id"];
            $query = '';
            if (!empty($idOrder)) {
                foreach ($carts as $cart) {
                    $query = $query . 'insert into order_details(order_id, product_id, capacity_id, quantity, price)values(
                    "' . $idOrder . '", "' . $cart["productId"] . '", "' . $cart["capacityId"] . '", "' . $cart["quantity"] . '"
                    , "' . $cart["detail"]["newPrice"] . '") ;';
                    $quantityRemain =  $cart["detail"]["quantityRemain"] - $cart["quantity"];
                    $query = $query . 'update product_capacities set quantity = "' . $quantityRemain . '" where id = "' . $cart["capacityId"] . '" and product_id = "' . $cart["productId"] . '"';
                };
                execute($query, true);
                Session::set("carts", array());
                echo "Đặt hàng thành công!";
            }
            http_response_code(201);
        }
    }
}
