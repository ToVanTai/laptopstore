<?php
    require_once "./utils/session.php";
    Session::init();
    if(!empty(Session::get("user"))){
        $id=Session::get("user")["id"];
    }
?>
<div class="container">
            <h3>Thông tin người dùng</h3>
            <div class="about__list">
                
            </div>
            <div class="container__infor__btn-change"><a class="change__infor" href="about.php?view=change">Đổi thông tin</a></div>
            <div class="container__infor__btn-change"><a class="change__infor" href="index.php">Trang chủ</a></div>
        </div>
        <script type="module" src="./js/components/aboutView.js"></script>