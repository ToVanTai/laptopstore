<?php
include_once __DIR__ . "/utils/index.php";
if (!empty(Session::get("user_id"))) {
    echo '<script>
            alert("Bạn đã đăng nhập.");
            window.location.href="' . baseUrl . '";
        </script>';
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập tài khoản</title>
    <link rel="stylesheet" href="./css/base/grid.css" />
    <link rel="stylesheet" href="./css/base/reset.css" />
    <link rel="stylesheet" href="./css/boxicons-2.0.7/css/boxicons.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="./css/pages/login/login2.css">
</head>

<body>
    <div class="container">
        <div class="container__registor">
            <div class="user__login__container">
                <h2 class="user__heading">
                    Đăng nhập ADMIN
                </h2>
                <form class="user__form" action="" method="POST">
                    <div class="user__input__field">
                        <input class="user__input" type="text" required placeholder="Nhập tên tài khoản" name="account"
                            id="account" />
                        <span class="user__input__field__icon"><i class='bx bx-user'></i></span>
                    </div>
                    <div class="user__input__field">
                        <input class="user__input" type="password" required placeholder="Nhập mật khẩu" name="password"
                            id="password" />
                        <span class="user__input__field__icon"><i class='bx bx-user'></i></span>
                    </div>
                    <input class="user__input" type="hidden" name="crud_req" value="login">
                    <button type="submit" class="user__btn__action active" id="btn-submit">Đăng nhập</button>
                </form>
                <div class="user__login__more__actions__createAccount">
                    <!-- <span href="register.php">Nếu bạn chưa có tài khoản?</span>
                    <a href="register.php">Đăng ký</a> -->
                </div>
            </div>

        </div>
    </div>
    <script type="module" src="./js/pages/login.js"></script>
</body>

</html>