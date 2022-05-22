<div class="container">
            <h3>Đổi thông tin</h3>
            <form class="form__about" action="" method="POST">
                <label for="name" >Họ và tên</label>
                <input type="text"  placeholder="Nhập họ tên"  required name="name"  id="name">

                <label for="phone_number">Số điện thoại</label>
                <input type="tel" placeholder="Nhập số điện thoại"  required name="phone_number"  id="phone_number">
                
                <label for="address" >Địa chỉ</label>
                <input type="text" placeholder="Nhập địa chỉ" required name="address"  id="address">
                
                <label for="avatar">Ảnh đại diện</label>
                <input type="file" name="avatar"  id="avatar">

                <label for="email">Email</label>
                <input type="email" placeholder="Nhập email" required name="email"  id="email">

                <div class="action">
                    <button type="submit">Lưu thay đổi</button>
                    <p>hoặc</p>
                    <a href="about.php">Trở lại</a>
                </div>
            </form>
        </div>