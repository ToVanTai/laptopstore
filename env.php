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
?>