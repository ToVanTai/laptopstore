<?php
include_once __DIR__ . "/../vendor/autoload.php";
use Predis\Client;
class RedisService{
    public static $redis;
    public static function init(){
        // Tạo một đối tượng client Redis với cấu hình
        self::$redis = new Client(REDIS_CONFIG);
        // Kiểm tra kết nối Redis
        try {
            self::$redis->ping();
        } catch (Exception $e) {
            
        }
         // Đăng ký hàm destroy() để được gọi khi quá trình thực thi kết thúc
        register_shutdown_function([self::class, 'destroy']);
    }

    public static function set($key, $val) {
        self::init();
        self::$redis->set($key, $val);
    }

    public static function get($key) {
        self::init();
        return self::$redis->get($key);
    }

    public static function deleteKey($key) {
        self::init();
        self::$redis->del($key);
    }

    public static function setKeyWithExpiration($key, $val, $expirationInSeconds) {
        self::init();
        self::$redis->setex($key, $expirationInSeconds, $val);
    }

    public static function keyExists($key) {
        self::init();
        return self::$redis->exists($key);
    }

    public static function destroy() {
        self::$redis->disconnect();
    }
}


