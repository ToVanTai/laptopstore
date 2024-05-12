<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header('Access-Control-Allow-Headers: Content-Type, access-token, refresh-token');
header("Access-Control-Allow-Credentials: true");
include_once __DIR__."/../utils/index.php";
Session::init();
include_once __DIR__ . "/../enum/index.php";
use laptopstore\enum\{StatusCodeResponse, EmailUserType};
//phần model
include __DIR__ . "/../model/index.php";
use laptopstore\model\{TokenInfo, UserEmailRegister};
/**
 * lấy dữ liệu thông tin người dùng
 */
if ($_SERVER["REQUEST_METHOD"] == "GET" && getGET("id") != null) {
    middleware(
        function() {
            resetPassword();
        },false
    );
    die();
}


/**
 * Lấy lại mật khẩu
 */
function resetPassword()
{
    $isSuccess = false;
    try{
        $id = getGET("id");
        $redisCacheUserJson = RedisService::get($id);
        if($redisCacheUserJson != null){
            RedisService::deleteKey($id);
            $userEmailInfor = json_decode($redisCacheUserJson);
            if($userEmailInfor != null && $userEmailInfor->type == EmailUserType::REST_PASSWORD){
                $query = 'select * from users where account="' . $userEmailInfor->account . '" limit 1';
                $isUnit = count(executeResult($query)) >= 1 ? false : true;
                if($isUnit == false && isset($userEmailInfor->account) && isset($userEmailInfor->hashedPassword)){
                    $query = 'update users set password = "' . $userEmailInfor->hashedPassword . '" where account = "' .$userEmailInfor->account. '";';
                    execute($query);
                    $isSuccess = true;
                }
            }
        }
    }catch(Exception $ex){
        
    }
    if($isSuccess == true){
        echo "Lấy lại mật khẩu thành công";
    }else{
        echo "lấy lại mật khẩu thất bại do quá hạn 5 phút";
    }
}
