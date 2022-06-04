<?php
    require_once "./utils/session.php";
    Session::init();
    if(!empty(Session::get("user"))){
        $id=Session::get("user")["id"];
    }
?>
<div class="container">
            <h3>Đổi thông tin</h3>
            <form class="form__about" enctype="multipart/form-data" action="" method="POST">

                <div class="action">
                    <button type="submit" id="btn-submit">Lưu thay đổi</button>
                    <p>hoặc</p>
                    <a href="about.php">Trở lại</a>
                </div>
            </form>
        </div>
        <script type="module" src="./js/components/aboutChange.js"></script>