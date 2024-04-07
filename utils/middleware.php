<?php
/**
 * cấu hình middleware cho api
 */
function middleware($next) {
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

    // Gọi tiếp theo middleware hoặc controller
    return $next();
}