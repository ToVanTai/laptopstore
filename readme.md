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

7. rabbit-mq
docker pull rabbitmq:3.12.13-management
b1:	Taỉ image
docker run -d -p 15672:15672 -p 5672:5672 rabbitmq:3.12.13-management
15672 là web
5672 là để kết nối
b1:	Build container từ imange
*lưu ý: phải vào trong phpinit bỏ gen đoạn socketextension=sockets

8. redis cache
docker pull redis
B1	Taỉ image
B2	docker run -p 6379:6379 -d redis
B3	Build container từ imange

8. redis-commander
chạy lệnh này là có port

