<?php
    const baseUrl = "http://localhost/laptopstore/";
    const origin = "http://localhost";
    const allowedOrigins = [
        'http://localhost',
        'http://localhost:3000',
        'http://localhost/laptopstore/'
    ];
    //cấu hình cho jwt services
    const secretKeyAccess = 'gsWcD8nWVJTKZXsN7a8GT2jNShpeF7uv';
    const secretKeyRefresh = 'qYanKDEuz7wqkdvTWxHeAKyW4MWjAhFT';
    //cấu hình redis
    const REDIS_CONFIG = [
        'scheme' => 'tcp',
        'host' => 'localhost',
        'port' => 6379,
        'password' => '',
    ];
    //format key cho refreshToken 
    const strRefreshToken = "refreshTokenUserID%dRoleID%d";
    //cấu hình gửi email
    const EMAIL_CONFIG = array(
        'FROM_EMAIL'=>"tovantaidz2002@gmail.com",
        'FROM_PASSWORD_EMAIL'=> "fhmk tqfc hfkb aonh",
        'HOST'=> 'smtp.gmail.com',
        'PORT'=> 587,
        'SMTPSecure' => 'tls',
        'SMTPAuth' => true,
        'Heading' => 'TOPLAP store',
    );

    //format key cho carts 
    const strCarts = "carts_%d";//userid
