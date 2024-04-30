<?php
include_once __DIR__."/jwt_services.php";
include __DIR__ . "/../enum/index.php";
use laptopstore\enum\{StatusCodeResponse};
/**
 * cấu hình middleware cho api
 * @next nếu thỏa mãn thì gọi hàm này
 * @isVerifyAccessToken api có cần verify accessToken không
 */
function middleware($next,$isVerifyAccessToken=true) {
    $http_origin = "";
    if (!empty($_SERVER['HTTP_ORIGIN'])) {
        if (in_array($_SERVER['HTTP_ORIGIN'], allowedOrigins)) {
            $http_origin = $_SERVER['HTTP_ORIGIN'];
        }
    }

    header("Access-Control-Allow-Origin: " . $http_origin);
    header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
    header("Access-Control-Allow-Credentials: true");

    // Thực hiện các xử lý trung gian khác tại đây nếu cần
    if($isVerifyAccessToken){
        $infoAccessToken = verifyAccessToken();//kiểm tra xem accessToken có hợp lệ hoặc hết hạn
        if($infoAccessToken === null || $infoAccessToken === false) {
            //kiểm tra xem refreshToken có hợp lệ hoặc hết hạn
            $infoRefreshToken = verifyRefreshToken();
            if($infoRefreshToken === null || $infoRefreshToken === false){
                if($infoRefreshToken === null){
                    http_response_code(StatusCodeResponse::Unauthorized);//token không hợp lệ hoặc 0 có
                    die();
                }else{
                    header('HTTP/1.1 440 Login Timeout');//đăng nhập bị hết hạn
                    die();
                }
            }else{
                return $next();
            }
        }else{
            return $next();
        }

    }else{
        return $next();
    }
}
