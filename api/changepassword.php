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
use laptopstore\model\{TokenInfo, UserEmailChangePassword};
/**
 * lấy dữ liệu thông tin người dùng
 */
if ($_SERVER["REQUEST_METHOD"] == "GET" && getGET("id") != null) {
    middleware(
        function() {
            changepassword();
        },false
    );
    Session::destroy();//nguy hiểm
    die();
}


/**
 * đăng ký mới tài khoản
 */
function changepassword()
{
    $isSuccess = false;
    try{
        $id = getGET("id");
        $redisCacheUserJson = RedisService::get($id);
        if($redisCacheUserJson != null){
            RedisService::deleteKey($id);
            $userEmailInfor = json_decode($redisCacheUserJson);
            if($userEmailInfor != null && $userEmailInfor->type == EmailUserType::CHANGE_PASSWORD && isset($userEmailInfor->account) && isset($userEmailInfor->hashedPassword) ){
                $query = 'update users set password = "' . $userEmailInfor->hashedPassword . '" where account= "' . $userEmailInfor->account . '" ;';
                execute($query);
                $isSuccess = true;
            }
        }
    }catch(Exception $ex){
        
    }
    if($isSuccess == true){
        echo "đổi mật khẩu thành công";
    }else{
        echo "Đổi mật khẩu thất bại do quá hạn 5 phút";
    }
}
