<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header('Access-Control-Allow-Headers: Content-Type, access-token, refresh-token');
header("Access-Control-Allow-Credentials: true");
include_once __DIR__."/../utils/index.php";
Session::init();
include_once __DIR__ . "/../enum/index.php";
use laptopstore\enum\{StatusCodeResponse};
//phần model
include __DIR__ . "/../model/index.php";
use laptopstore\model\{TokenInfo};
/**
 * lấy dữ liệu thông tin người dùng
 */
if ($_SERVER["REQUEST_METHOD"] == "GET" && getGET("refresh-token") != null) {
    middleware(
        function() {
            refreshToken();
        },false
    );
    die();
}
/**
 * lấy dữ liệu thông tin người dùng
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    middleware(
        function() {
            about();
        }
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['crud_req'])) {
    middleware(
        function() {
            logout();
        }, false//tạm thời để kiểu này
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "register") {
    middleware(
        function() {
            register();
        },false
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "login") {
    middleware(
        function() {
            login();
        }, false
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['crud_req'] == "update") {
    middleware(
        function() {
            update1();
        }
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] =="POST" && $_POST['crud_req'] == "changePassword") {//change patch to post
    middleware(
        function() {
            updatev2();
        }
    );
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['crud_req']) && $_GET["crud_req"] == "logout") {//change delete to post
    middleware(
        function() {
            logout();
        }
    );
    die();
}
/**
 * lấy dữ liệu thông tin người dùng
 */
function about()
{
    $a = Session::get("user_id");
    $b = Session::get("role_id");
    $responseData = [];
    if (!empty(Session::get("user_id"))) {
        $idUser = Session::get("user_id");
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
    };
}

/**
 * đăng ký mới tài khoản
 */
function register()
{
    $account = getPOST("account");
    $password = getPOST("password");
    $query = 'select * from users where account="' . $account . '" limit 1';
    $isUnit = count(executeResult($query)) >= 1 ? false : true;
    if ($isUnit == false) {
        http_response_code(StatusCodeResponse::NonAuthoritativeInformation);
        echo "Tài khoản đã tồn tại trên hệ thống";
        die();
    }else{
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $role_id = 1; //users
        $created_at = date("Y-m-d h:i:s");
        $updated_at = $created_at;
        $query = 'insert into users(role_id, account, password, created_at, updated_at) values("' . $role_id . '", "' . $account . '", "' . $hashedPassword . '", "' . $created_at . '", "' . $updated_at . '");';
        execute($query);
        http_response_code(StatusCodeResponse::Created);
    }
}

/**
 * đăng nhập
 */
function login()
{
    $account = getPOST("account");
    $password = getPOST("password");
    $query = 'select * from users where account = "' . $account . '" limit 1';
    $responseData = executeResult($query);
    $isSuccessfully = false;
    if(count($responseData) >= 1){
        $hashPassword = $responseData[0]["password"];
        if (password_verify($password, $hashPassword)) {
            $isSuccessfully = true;
        } 
    }
    if ($isSuccessfully == true) {
        $userInfo = $responseData[0];
        http_response_code(200);
        $user = array("id" => $userInfo["id"], "role" => $userInfo["role_id"], "name" => $userInfo["name"], "avatar" => $userInfo["avatar"]);
        //đăng ký access token theo userid, roleid
        $accessToken = signAccessToken($userInfo["id"],$userInfo["role_id"]);
        $refreshToken = signRefreshToken($userInfo["id"],$userInfo["role_id"]);
        $tokenInfo = new TokenInfo(array(
            "AccessToken" => $accessToken,
            "RefreshToken" => $refreshToken,
            "user_id" =>  $userInfo["id"],
            "role_id" => $userInfo["role_id"],
        ));
        if($accessToken != null){
            //gán refreshToken vào redis
            $formattedStringToken =  sprintf(strRefreshToken, $userInfo["id"], $userInfo["role_id"]);
            RedisService::setKeyWithExpiration($formattedStringToken, $refreshToken, 59*60);
            echo json_encode($tokenInfo->getTokenInfo());
            Session::set("user", $user);
            Session::set("user_id",$userInfo["id"]);
            Session::set("role_id",$userInfo["role_id"]);
            if (empty(Session::get("carts"))) {
                Session::set("carts", array());
            }
        }else{
            http_response_code(203);
            echo "Tên tài khoản hoặc mật khẩu không chính xác";
        }
    } else {
        http_response_code(203);
        echo "Tên tài khoản hoặc mật khẩu không chính xác";
    }
}

/**
 * lấy tại accessToken
 */
function refreshToken(){
    $generateAccessToken = generateAccessTokenByRefreshToken();
    if($generateAccessToken === null || $generateAccessToken === false) {
        if($generateAccessToken === null){
            http_response_code(StatusCodeResponse::Unauthorized);//token không hợp lệ hoặc 0 có
            die();
        }else{
            header('HTTP/1.1 440 Login Timeout');//đăng nhập bị hết hạn
            die();
        }
    }else{
        $tokenInfo = new TokenInfo($generateAccessToken);
        Session::set("user_id",$generateAccessToken["user_id"]);
        Session::set("role_id",$generateAccessToken["role_id"]);
        if (empty(Session::get("carts"))) {
            Session::set("carts", array());
        }
        //gán refreshToken vào redis
        $formattedStringToken =  sprintf(strRefreshToken, $generateAccessToken["user_id"], $generateAccessToken["role_id"]);
        RedisService::setKeyWithExpiration($formattedStringToken, $generateAccessToken["RefreshToken"], 59*60);
        echo json_encode($tokenInfo->getTokenInfo());
    }
}

/**
 * đăng xuất
 */
function logout()
{
    delRefreshToken();
    Session::destroy();
    http_response_code(200);
}

/**
 * đổi thông tin cá nhân
 */
function update1()
{
    if (!empty(Session::get("user_id"))) {
        $id = Session::get("user_id");
        $name = getPOST("name");
        $phoneNumber = getPOST("phone_number") == null ? "" : getPOST("phone_number");
        $address = getPOST("address");
        $email = getPOST("email");
        $avatarFiles = $_FILES["avatar"];
        $successMes = "Cập nhật thông tin cá nhân thành công";
        $failMess = "Cập nhật thất bại";
        $updated_at = date("Y-m-d h:i:s");
        if (empty($avatarFiles["name"])) {
            $query = 'UPDATE users SET name="' . $name . '", phone_number="' . $phoneNumber . '",
            address="' . $address . '", email="' . $email . '", updated_at="' . $updated_at . '" WHERE id=' . $id . ';';
            execute($query);
            echo $successMes;
            http_response_code(201);
            $query = 'select * from users where id=' . $id . ' limit 1';
            $aboutUse = executeResult($query);
            if (count($aboutUse) >= 1) {
                $user = array("id" => $aboutUse[0]["id"], "role" => $aboutUse[0]["role_id"], "name" => $aboutUse[0]["name"], "avatar" => $aboutUse[0]["avatar"]);
                Session::set("user", $user);
            }
            die();
        } else {
            $avatarName = time() . $avatarFiles["name"];
            $formFile = $avatarFiles["tmp_name"];
            $toFile = "../store/" . $avatarName;
            $query = "select * from users where id=" . $id . " limit 1";
            $dataOld = executeResult($query, true);
            $avartarOld = !empty($dataOld["avatar"]) ? $dataOld["avatar"] : null;
            if (count($dataOld) >= 1) {
                $query = 'UPDATE users SET name="' . $name . '", phone_number="' . $phoneNumber . '",
                            address="' . $address . '", email="' . $email . '",avatar="' . $avatarName . '", updated_at="' . $updated_at . '" WHERE id=' . $id . ';';
                if ($avartarOld == null) { //không cần xóa file cũ
                    if (validateFile($_FILES["avatar"]) != "") { //file khong hop le
                        echo validateFile($_FILES["avatar"]);
                        http_response_code(203);
                        die();
                    } else {
                        if (move_uploaded_file($formFile, $toFile)) {
                            execute($query);
                            echo $successMes;
                            http_response_code(201);
                        } else {
                            echo $failMess;
                            http_response_code(203);
                            die();
                        }
                    }
                } else { //phải xóa file cũ
                    if (validateFile($_FILES["avatar"]) != "") { //file khong hop le
                        echo validateFile($_FILES["avatar"]);
                        http_response_code(203);
                        die();
                    } else {
                        if (file_exists("../store/" . $avartarOld)) {
                            unlink("../store/" . $avartarOld);
                            if (move_uploaded_file($formFile, $toFile)) {
                                execute($query);
                                http_response_code(201);
                                echo $successMes;
                            } else {
                                echo $failMess;
                                http_response_code(203);
                                die();
                            }
                        } else {
                            if (move_uploaded_file($formFile, $toFile)) {
                                execute($query);
                                echo $successMes;
                                http_response_code(201);
                            } else {
                                echo $failMess;
                                http_response_code(203);
                                die();
                            }
                        }
                    }
                }
                $query = 'select * from users where id=' . $id . ' limit 1';
                $aboutUse = executeResult($query);
                if (count($aboutUse) >= 1) {
                    $user = array("id" => $aboutUse[0]["id"], "role" => $aboutUse[0]["role_id"], "name" => $aboutUse[0]["name"], "avatar" => $aboutUse[0]["avatar"]);
                    Session::set("user", $user);
                }
            }
            die();
        }
    }
}

/**
 * đối mật khẩu
 */
function updatev2()
{
    $errMessage = "";
    if (empty(Session::get("user_id"))) {
        $errMessage = $errMessage . "Bạn chưa đăng nhập!\n";
        echo $errMessage;
        http_response_code(203);
        die();
    };
    $idUser = Session::get("user_id");
    $account = getPOST("account");
    $password = getPOST("password");
    $newPassword = getPOST("newPassword");

    $query = "select account from users where id = '" . $idUser . "'  and  account = '" . $account . "'  and  password = '" . md5($password) . "' ;";
    $resOld = executeResult($query);
    if (count($resOld) >= 1) {
        if ($newPassword == $password) {
            $errMessage = $errMessage . "Mật khẩu cũ với mật khẩu mới không được khớp!\n";
            echo $errMessage;
            http_response_code(203);
            die();
        } else {
            $query = 'update users set password = "' . md5($newPassword) . '" where id = "' . $idUser . '" and account= "' . $account . '" and password = "' . md5($password) . '" ;';
            execute($query);
            http_response_code(201);
            echo "Cập nhật thành công!\nVui lòng đăng nhập lại.";
            Session::destroy();
        }
    } else {
        echo "Mật khẩu không đúng!\n";
        http_response_code(203);
        die();
    }
}
