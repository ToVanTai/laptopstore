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
            register();
        },false
    );
    die();
}


/**
 * đăng ký mới tài khoản
 */
function register()
{
    $isSuccess = false;
    try{
        $id = getGET("id");
        $redisCacheUserJson = RedisService::get($id);
        if($redisCacheUserJson != null){
            RedisService::deleteKey($id);
            $userEmailInfor = json_decode($redisCacheUserJson);
            if($userEmailInfor != null && $userEmailInfor->type == EmailUserType::REGISTER && isset($userEmailInfor->role_id) && isset($userEmailInfor->account) && isset($userEmailInfor->hashedPassword)){
                $query = 'select * from users where account="' . $userEmailInfor->account . '" limit 1';
                $isUnit = count(executeResult($query)) >= 1 ? false : true;
                if($isUnit == true){
                    $query = 'insert into users(role_id, account, password, created_at, updated_at) values("' . $userEmailInfor->role_id . '", "' . $userEmailInfor->account . '", "' . $userEmailInfor->hashedPassword . '", "' . $userEmailInfor->created_at . '", "' . $userEmailInfor->updated_at . '");';
                    execute($query);
                    $isSuccess = true;
                }
            }
        }
    }catch(Exception $ex){
        
    }
    if($isSuccess == true){
        echo "Tài khoản của bạn đã được kích hoạt";
    }else{
        echo "Kích hoạt tài khoản thất bại do tài khoản đã tồn tại hoặc quá hạn 5 phút";
    }
}
