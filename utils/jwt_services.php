<?php
include_once __DIR__ . "/../vendor/autoload.php";
use Firebase\JWT\JWT;
//phần model
include __DIR__ . "/../model/index.php";
use laptopstore\model\{TokenInfo};
/**
 * hàm này trả về đối tượng tokenInfo bao gồm các thuộc tính...
 */
function signAccessToken($id, $role_id)
{
    try {
        //validate
        if(empty($role_id) || empty($id)){
            return null;
        } 
        // Tạo JWT
        $payload1 = array(
            "user_id" => $id,
            "role_id" => $role_id,
            "exp" => getDateForToken('PT1M') // Thời hạn 15 phút tính theo múi giờ UTC
        );


        $accessToken = JWT::encode($payload1, secretKeyAccess, 'HS256');
        return $accessToken;
    } catch (Exception $e) {

    }
    return null;
}

function signRefreshToken($id, $role_id)
{
    try {
        //validate
        if(empty($role_id) || empty($id)){
            return null;
        } 
        
        $payload2 = array(
            "user_id" => $id,
            "role_id" => $role_id,
            "exp" => getDateForToken('P1Y') // Thời hạn 15 phút tính theo múi giờ UTC
        );

        $refreshToken = JWT::encode($payload2, secretKeyRefresh, 'HS256');
        return $refreshToken;
    } catch (Exception $e) {

    }
    return null;
}

/**
 * hàm để verify access token.
 * null: nếu không verify
 * đối tượng tokenInfo
 * null: không có license
 * false: hết hạn license
 * đối tượng TokenInfo
 */
function verifyAccessToken(){
    if(isset($_SERVER['HTTP_ACCESS_TOKEN'])){
        $accessToken = $_SERVER['HTTP_ACCESS_TOKEN'];
        try {
            // Xác minh tính hợp lệ của access token
            $decodedAccessToken = JWT::decode($accessToken, secretKeyAccess, ['HS256']);
            $tokenInfo = new TokenInfo();
            $tokenInfo->setTokenInfo($decodedAccessToken);
            return $tokenInfo->getTokenInfo();
        } catch (Exception $e) {
            return $e->getMessage() == "Expired token" ? false : null;
        }
    }else{
        return null;
    }
}

/**
 * hàm để lấy accessToken mới dựa vào refreshToken.
 * đối tượng tokenInfo
 * null: không có license
 * false: hết hạn license
 */
function generateAccessTokenByRefreshToken(){
    if(isset($_SERVER['HTTP_REFRESH_TOKEN'])){
        $refreshToken = $_SERVER['HTTP_REFRESH_TOKEN'];
        try {
            // Xác minh tính hợp lệ của access token
            $decodedRefreshToken = JWT::decode($refreshToken, secretKeyRefresh, ['HS256']);
            // $tokenInfo = new TokenInfo();
            // $tokenInfo->setTokenInfo($decodedRefreshToken);
            $signAccessToken = signAccessToken($decodedRefreshToken->user_id, $decodedRefreshToken->role_id);
            return array(
                'AccessToken' => $signAccessToken,
                'RefreshToken' => $refreshToken,
                'role_id' => $decodedRefreshToken->role_id,
                'user_id' => $decodedRefreshToken->user_id
            );
        } catch (Exception $e) {
            return $e->getMessage() == "Expired token" ? false : null;
        }
    }else{
        return null;
    }
}
/**
 * hàm để verify access token.
 * null: nếu không verify
 * đối tượng tokenInfo
 * null: không có license
 * false: hết hạn license
 * đối tượng TokenInfo
 */
function verifyRefreshToken(){
    if(isset($_SERVER['HTTP_REFRESH_TOKEN'])){
        $refreshToken = $_SERVER['HTTP_REFRESH_TOKEN'];
        try {
            // Xác minh tính hợp lệ của access token
            $decodedRefreshToken = JWT::decode($refreshToken, secretKeyRefresh, ['HS256']);
            // $tokenInfo = new TokenInfo();
            // $tokenInfo->setTokenInfo($decodedRefreshToken);
            $signAccessToken = signAccessToken($decodedRefreshToken->user_id, $decodedRefreshToken->role_id);
            $decodedAccessToken = JWT::decode($signAccessToken, secretKeyAccess, ['HS256']);
            $tokenInfo = new TokenInfo();
            $tokenInfo->setTokenInfo($decodedAccessToken);
            return $tokenInfo->getTokenInfo();
        } catch (Exception $e) {
            return $e->getMessage() == "Expired token" ? false : null;
        }
    }else{
        return null;
    }
}

function delRefreshToken()
{
    if(isset($_SERVER['HTTP_REFRESH_TOKEN'])){
        $refreshToken = $_SERVER['HTTP_REFRESH_TOKEN'];
        try {
            // Xác minh tính hợp lệ của access token
            $decodedRefreshToken = JWT::decode($refreshToken, secretKeyRefresh, ['HS256']);
            $formattedStringToken =  sprintf(strRefreshToken, $decodedRefreshToken->user_id, $decodedRefreshToken->role_id);
            RedisService::deleteKey($formattedStringToken);
        } catch (Exception $e) {
            return $e->getMessage() == "Expired token" ? false : null;
        }
    }else{
        return null;
    }
}

/**
 * P1Y: 1 năm
 * PT1HL: 1 giờ 
 * PT15M: 15 phút
 * P15D: 15 ngày
 */
function getDateForToken($str){
    $interval = new DateInterval($str);

    $expirationTime = new DateTime();
    $expirationTime->add($interval);
    return $expirationTime->getTimestamp();
}


