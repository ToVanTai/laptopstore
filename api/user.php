<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: POST,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
Session::init();
//dữ liệu được gửi toàn bộ từ form
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['crud_req'])) {
    logout($conn);
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "register") {
    register(); //đăng ký tài khoản 
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "login") {
    login();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "update") {
    update1($conn);
}
if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    update($conn);
}
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    logout();
}

function register()
{
    $account = getPOST("account");
    $password = getPOST("password");
    $accountReg = "/^[\S]{3,15}$/";
    $passwordReg = "/^\S{3,15}$/";
    $messageErr = "";
    $isErr = false;
    if ($account==null||$password==null) {
        $isErr = true;
        $messageErr="Vui lòng điền đầy đủ thông tin.";
    } 
    else {
        if (!preg_match($accountReg, $account)) {
            $isErr = true;
            $messageErr = $messageErr."Tên tài khoản: dài từ 3->15 ký tự, không chứa khoảng trắng. ";
        }
        if (!preg_match($passwordReg, $password)) {
            $isErr = true;
            $messageErr = $messageErr."Mật khẩu: dài từ 3->15 ký tự, không được có khoảng trắng. ";
        }
    }
    $query = 'select * from users where account="' . $account . '"';
    $isUnit = count(executeResult($query)) >= 1 ? false : true;
    if($isUnit==false){
        $isErr=true;
        $messageErr="Tài khoản đã tồn tại trên hệ thống";
    }
    if($isErr==true){
        http_response_code(203);
        echo $messageErr;
        die();
    }
    $passwordMd5=md5($password);
    $role_id=1;
    $created_at=date("Y-m-d h:i:s");
    $updated_at=date("Y-m-d h:i:s");
    $query='insert into users(role_id, account, password, created_at, updated_at) values("'.$role_id.'", "'.$account.'", "'.$passwordMd5.'", "'.$created_at.'", "'.$updated_at.'");';
    execute($query);
    $query = 'select * from users where account="' . $account . '"';
    if(count(executeResult($query)) >= 1 ? true : false){
        http_response_code(201);
    }else{
        http_response_code(203);
        echo "Đăng ký tài khoản thất bại";
    }
}
function login()
{
    $account = getPOST("account");
    $password = getPOST("password");
    $messageErr = "";
    if ($account==null||$password==null) {
        $messageErr="Vui lòng điền đầy đủ thông tin.";
        http_response_code(203);
        echo $messageErr;
        die();
    }
    $query='select * from users where account = "'.$account.'" and password = "'.md5($password).'"';
    $responseData=executeResult($query);
    $isSuccessfully=count($responseData)>=1?true:false;
    if($isSuccessfully==true){
        http_response_code(200);
        $user = array("id"=>$responseData[0]["id"],"role"=>$responseData[0]["role_id"],"name"=>$responseData[0]["name"],"avatar"=>$responseData[0]["avatar"]);
        Session::set("user",$user);
    }else{
        http_response_code(203);
        echo "Đăng nhập thất bại";
    }

}
function logout()
{
    if (!isset($_SESSION['users'])) {
        echo "ban chua login";
        http_response_code(400);
    } else {
        unset($_SESSION['users']);
        session_destroy();
        echo "dang xuat thanh cong";
        http_response_code(200);
    }
    die();
}
function update1($conn)
{
    //parse_str(file_get_contents("php://input"), $_PATCH);
    $name = $_POST['name'];
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if ($new_password == $confirm_password) {
        if (isset($_FILES['img']['name'])) {
            $sql = "select * from users where name = '" . $name . "' and password = '" . $password . "' ;";
            $dataRes = mysqli_query($conn, $sql);
            if (mysqli_num_rows($dataRes) > 0) {
                $data = mysqli_fetch_assoc($dataRes);
                if (file_exists($data['img'])) {
                    unlink($data['img']);
                };
                if (true) {
                    $target_mkdir = 'files/';
                    $target_touch = $target_mkdir . time() . $_FILES['img']['name'];
                    move_uploaded_file($_FILES['img']['tmp_name'], $target_touch);
                    $sql = "update users set password = '" . $new_password . "', img = '" . $target_touch . "' where name = '" . $name . "' ;";
                    mysqli_query($conn, $sql);
                    echo "cap nhat mk thanh " . $new_password . " cap nhat anh thanh cong";
                    http_response_code(200);
                    die();
                };
                echo "cap nhap khong thanh";
            } else {
                echo "thong tin tai khoan mat khau khong hop le";
                http_response_code(400);
                die();
            }
        } else {
            $sql = "select password from users where name = '" . $name . "' and password = '" . $password . "' ;";
            $dataRes = mysqli_query($conn, $sql);
            if (mysqli_num_rows($dataRes) > 0) {
                $sql = "update users set password = '" . $new_password . "' where name = '" . $name . "' ;";
                mysqli_query($conn, $sql);
                echo "cap nhat mk thanh " . $new_password;
                http_response_code(200);
                die();
            } else {
                echo "thong tin tai khoan mat khau khong hop le";
                http_response_code(400);
                die();
            }
        }
    } else {
        echo "mat khau khong khop";
        http_response_code(400);
        die();
    }
}
function update($conn)
{
    parse_str(file_get_contents("php://input"), $_PATCH);
    $name = $_PATCH['name'];
    $password = $_PATCH['password'];
    $new_password = $_PATCH['new_password'];
    $confirm_password = $_PATCH['confirm_password'];
    // $sql = ""

    // $data = json_decode(file_get_contents("php://input"),true);
    // echo $data['img']['name'];

    // $name = $data['name'];
    // $password = $data['password'];
    // $new_password = $data['new_password'];
    // $confirm_password = $data['confirm_password'];


    if ($new_password == $confirm_password) {
        $sql = "select password from users where name = '" . $name . "' and password = '" . $password . "' ;";
        $dataRes = mysqli_query($conn, $sql);
        if (mysqli_num_rows($dataRes) > 0) {
            $sql = "update users set password = '" . $new_password . "' where name = '" . $name . "' ;";
            mysqli_query($conn, $sql);
            echo "cap nhat mk thanh " . $new_password;
            http_response_code(200);
            die();
        } else {
            echo "thong tin tai khoan mat khau khong hop le";
            http_response_code(400);
            die();
        }
    } else {
        echo "mat khau khong khop";
        http_response_code(400);
        die();
    }
}


