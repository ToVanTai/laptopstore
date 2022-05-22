<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Đăng ký tài khoản</title>
        <link rel="stylesheet" href="./css/base/grid.css" />
        <link rel="stylesheet" href="./css/base/reset.css" />
        <link
            href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="./css/pages/register/register.css" />
    </head>
    <body>
        <div class="container">
            <div class="container__registor">
                <h3>Đăng ký tài khoản</h3>
                <form class="form__register" action="" method="POST">
                    <label for="account">Tên tài khoản</label>
                    <input type="text" placeholder="Nhập tên tài khoản" name="account" id="account" />
                    <label for="password">Mật khẩu</label>
                    <input type="password" placeholder="Nhập mật khẩu" name="password" id="password" />
                    <label for="confirm-password">Xác nhận Mật khẩu</label>
                    <input
                        type="password"
                        name="confirm-password"
                        id="confirm-password"
                        placeholder="Xác nhận mật khẩu"
                    />
                    <button type="submit">Đăng ký</button>
                </form>
                <div class="login">
                    <span>Nếu bạn đã có tài khoản?</span>
                    <a href="login.php">Đăng nhập</a>
                </div>
            </div>
        </div>
    </body>
</html>
