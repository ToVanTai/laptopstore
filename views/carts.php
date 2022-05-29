<!-- start carts -->
<div class="carts__container">
    <div class="carts__heading">
        Giỏ hàng
    </div>
    <table class="carts__table" border="1">
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Phân loại</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
            <th>Xóa</th>
        </tr>
        <tr>
            <td>
                <a href="">
                    <img src="./access/imgs/product1.png" alt="">
                </a>
            </td>
            <td>
                <a href="">
                    <p>Laptop Acer Aspire 3 A315 56 37DV</p>
                </a>
            </td>
            <td>Red, 8GB/SSD 225GB/HDD 1TB</td>
            <td>
                <input type="number" name="" id="">
            </td>
            <td>
                10,999,000<u>đ</u>
            </td>
            <td>
                <span><i class='bx bx-trash' ></i></span>
            </td>
        </tr>
    </table>
    <div class="carts__total">
        <span class="carts__total-title">Tổng tiền:</span>
        <span class="carts__total-total">24,000,000<u>đ</u></span>
    </div>
    <textarea name="notes" id="" placeholder="Ghi chú" rows="3"></textarea>
    <div class="carts__btn">
        <span class="carts__btn-pay">Thanh toán</span>
        <span class="carts__btn-update">Cập nhật</span>
        <a class="carts__btn-purchased" href="index.php?view=purchased">Đã mua</a>
    </div>
</div>
<script type="module" src="./js/components/cartsContainer.js"></script>
<!-- end carts__container -->