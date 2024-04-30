===
1. tên dự án: website bán laptop (toplap)
2. database: mysqli
3. cài đặt composer:
    "E:\php\php\php.exe"   (đường dẫn thư mục xampp)
    * download composer: https://getcomposer.org/download/ 
        B1: chạy file Composer-Setup.exe => oke...
        B2: shift + click chuật phải để mở power shell và cài đặt composer 
        B3: cài đặt thôi hoặc dùng composer init
4. cấu hình debug: 
    * trong file: php/php.ini cho đoạn code sau: 
    zend_extension = xdebug
    [XDebug]
    xdebug.mode = debug
    xdebug.start_with_request = yes
    *cài extension xdebugger: và vào setting cho đoạn mã này vào
        {
            "php.debug.executablePath": "E:\\php\\php\\php.exe",
        }
    
5. phpredis
composer require predis
6. redis-commander
