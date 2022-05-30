<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Allow-Credentials: true");
Session::init();
//dữ liệu được gửi toàn bộ từ form\
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    about();
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['crud_req'])) {
    logout(); //oke
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "register") {
    register(); //oke
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "login") {
    login(); //oke
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "update") {
    update1();
    die();
}
// if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
//     update();
//     die();
// }
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    logout(); //oke
    die();
}
function about()
{
    $idUser = getGET("id");
    $responseData = [];
    if (!empty(Session::get("user"))) {
        if ($idUser != null || $idUser >= 0) {
            $query = 'select * from users where id = ' . $idUser . ' limit 1;';
            $response = executeResult($query, true);
            $responseData = array(
                "id" => $response["id"],
                "account" => $response["account"],
                "name" => $response["name"],
                "phone_number" => $response["phone_number"],
                "address" => $response["address"],
                "avatar" => $response["avatar"],
                "email" => $response["email"]
            );
            echo json_encode($responseData);
            http_response_code(200);
            die();
        }
    }
    http_response_code(200);
    echo json_encode($responseData);
}

function register()
{
    $account = getPOST("account");
    $password = getPOST("password");
    $accountReg = "/^[a-z0-9]{3,15}$/";
    $passwordReg = "/^\S{3,15}$/";
    $messageErr = "";
    $isErr = false;
    if ($account == null || $password == null) {
        $isErr = true;
        $messageErr = "Vui lòng điền đầy đủ thông tin.";
    } else {
        if (!preg_match($accountReg, $account)) {
            $isErr = true;
            $messageErr = $messageErr . "Tên tài khoản: dài từ 3->15 ký tự, chỉ bao gồm chữ thường, số, không chứa khoảng trắng. ";
        }
        if (!preg_match($passwordReg, $password)) {
            $isErr = true;
            $messageErr = $messageErr . "Mật khẩu: dài từ 3->15 ký tự, không được có khoảng trắng. ";
        }
    }
    $query = 'select * from users where account="' . $account . '" limit 1';
    $isUnit = count(executeResult($query)) >= 1 ? false : true;
    if ($isUnit == false) {
        $isErr = true;
        $messageErr = "Tài khoản đã tồn tại trên hệ thống";
    }
    if ($isErr == true) {
        http_response_code(203);
        echo $messageErr;
        die();
    }
    $passwordMd5 = md5($password);
    $role_id = 1;
    $created_at = date("Y-m-d h:i:s");
    $updated_at = date("Y-m-d h:i:s");
    $query = 'insert into users(role_id, account, password, created_at, updated_at) values("' . $role_id . '", "' . $account . '", "' . $passwordMd5 . '", "' . $created_at . '", "' . $updated_at . '");';
    execute($query);
    $query = 'select * from users where account="' . $account . '" limit 1';
    $result = executeResult($query);
    if (count($result) >= 1 ? true : false) {
        http_response_code(201);
    } else {
        http_response_code(203);
        echo "Đăng ký tài khoản thất bại";
    }
}
//ă â đ ê ô ơ ư Â Ă Đ Ê Ô Ơ Ư
function login()
{
    $account = getPOST("account");
    $password = getPOST("password");
    $messageErr = "";
    if ($account == null || $password == null) {
        $messageErr = "Vui lòng điền đầy đủ thông tin.";
        http_response_code(203);
        echo $messageErr;
        die();
    }
    $query = 'select * from users where account = "' . $account . '" and password = "' . md5($password) . '" limit 1';
    $responseData = executeResult($query);
    $isSuccessfully = count($responseData) >= 1 ? true : false;
    if ($isSuccessfully == true) {
        http_response_code(200);
        $user = array("id" => $responseData[0]["id"], "role" => $responseData[0]["role_id"], "name" => $responseData[0]["name"], "avatar" => $responseData[0]["avatar"]);
        Session::set("user", $user);
    } else {
        http_response_code(203);
        echo "Tên tài khoản hoặc mật khẩu không chính xác";
    }
}
function logout()
{
    Session::destroy();
    http_response_code(200);
}
function update1()
{
    if (!empty(Session::get("user"))) {
        $id = getGET("id");
        $name = getPOST("name");
        $phoneNumber = getPOST("phone_number");
        $address = getPOST("address");
        $email = getPOST("email");
        $avatarFiles = $_FILES["avatar"];
        $nameReg = "/^[0-9a-zA-Z\săâđêôơưÂĂĐÊÔƠƯ]{3,15}$/";
        $successMes="Cập nhật thông tin cá nhân thành công";
        $failMess="Cập nhật thất bại";
        $updated_at= date("Y-m-d h:i:s");
        if (preg_match($nameReg, $name)) {
            if (empty($avatarFiles["name"])) {
                $query = 'UPDATE users SET name="' . $name . '", phone_number="' . $phoneNumber . '",
            address="' . $address . '", email="' . $email . '", updated_at="'.$updated_at.'" WHERE id=' . $id . ';';
                execute($query);
                echo $successMes;
                http_response_code(203);
            } else {
                $avatarName = time() . $avatarFiles["name"];
                $formFile = $avatarFiles["tmp_name"];
                $toFile = "../store/".$avatarName;
                $query = "select * from users where id=" . $id . " limit 1";
                $avartarOld = executeResult($query)[0]["avatar"];

                if (count(executeResult($query)) >= 1) {
                    $query = 'UPDATE users SET name="' . $name . '", phone_number="' . $phoneNumber . '",
                                address="' . $address . '", email="' . $email . '",avatar="' . $avatarName . '", updated_at="'.$updated_at.'" WHERE id='.$id.';';
                    if($avartarOld==null){//không cần xóa file cũ
                        if(validateFile($_FILES["avatar"])!=""){
                            echo validateFile($_FILES["avatar"]);
                            http_response_code(200);
                        }else{
                            if(move_uploaded_file($formFile,$toFile)){
                                execute($query);
                                echo $successMes;
                            }else{
                                echo $failMess;
                            }
                        }
                    }else{//phải xóa file cũ
                        if(validateFile($_FILES["avatar"])!=""){
                            echo validateFile($_FILES["avatar"]);
                            http_response_code(200);
                        }else{
                            if(file_exists("../store/".$avartarOld)){
                                unlink("../store/".$avartarOld);
                                if(move_uploaded_file($formFile,$toFile)){
                                    execute($query);
                                    echo $successMes;
                                }else{
                                    echo $failMess;
                                }
                            }else{
                                if(move_uploaded_file($formFile,$toFile)){
                                    execute($query);
                                    echo $successMes;
                                }else{
                                    echo $failMess;
                                }
                            }
            
                        }

                    }
                    $query = 'select * from users where id='.$id.' limit 1';
                    $aboutUse=executeResult($query);
                    if(count($aboutUse)>=1){
                        $user = array("id" => $aboutUse[0]["id"], "role" => $aboutUse[0]["role_id"], "name" => $aboutUse[0]["name"], "avatar" => $aboutUse[0]["avatar"]);
                        Session::set("user", $user);
                    }
                }
            }
        } else {
            http_response_code(203);
            echo "tên người dùng: dài từ 3->15 ký tự, chỉ bao gồm số và chữ, khoảng trắng. ";
        }
    }
}
// function update()
// {
//     parse_str(file_get_contents("php://input"), $_PATCH);
//     $name = $_PATCH['name'];
//     $password = $_PATCH['password'];
//     $new_password = $_PATCH['new_password'];
//     $confirm_password = $_PATCH['confirm_password'];
//     // $sql = ""

//     // $data = json_decode(file_get_contents("php://input"),true);
//     // echo $data['img']['name'];

//     // $name = $data['name'];
//     // $password = $data['password'];
//     // $new_password = $data['new_password'];
//     // $confirm_password = $data['confirm_password'];


//     // if ($new_password == $confirm_password) {
//     //     $sql = "select password from users where name = '" . $name . "' and password = '" . $password . "' limit 1;";
//     //     $dataRes = mysqli_query($conn, $sql);
//     //     if (mysqli_num_rows($dataRes) > 0) {
//     //         $sql = "update users set password = '" . $new_password . "' where name = '" . $name . "' ;";
//     //         mysqli_query($conn, $sql);
//     //         echo "cap nhat mk thanh " . $new_password;
//     //         http_response_code(200);
//     //         die();
//     //     } else {
//     //         echo "thong tin tai khoan mat khau khong hop le";
//     //         http_response_code(400);
//     //         die();
//     //     }
//     // } else {
//     //     echo "mat khau khong khop";
//     //     http_response_code(400);
//     //     die();
//     // }
// }
