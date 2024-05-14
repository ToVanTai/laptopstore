<?php
    namespace laptopstore\enum;
    /**
     * các status code có trong chương trình
     */
    final class EmailUserType{
        public const REGISTER = 1;//ĐĂNG KÝ TÀI KHOẢN
        public const REST_PASSWORD = 2;//QUÊN MẬT KHẨU
        public const CHANGE_PASSWORD = 3;//ĐỔI MẬT KHẨU
    }
?>