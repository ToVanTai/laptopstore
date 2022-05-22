<!-- start carts -->
<div class="carts__container">
            <div class="carts__container__header">
                <span data-type="carts" class="carts__container__header__control active">
                    Giỏ hàng
                </span>
                <span class="carts__container__header__control-wall">|</span>
                <span data-type="carts-ordered" class="carts__container__header__control">
                    Đã đặt
                </span>
            </div>

            <div class="carts__container__list__cart show">
                <div class="carts__container__item">
                    <a href="index.php?view=product&id=1" class="carts__container__item__detail">
                        <div class="carts__container__item__detail__img">
                            <img src="./access/imgs/product11-300x300.jpg" alt="">
                        </div>
                        <div class="carts__container__item__detail__content">
                            <p class="carts__container__item__detail__title">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            </p>
                            <div class="carts__container__item__detail__price">
                                <span class="carts__container__item__detail__price-old"><sup>đ</sup>20.000</span>
                                <span class="carts__container__item__detail__price-current"><sup>đ</sup>20.000</span>
                            </div>
                        </div>
                    </a>
                    <div class="carts__container__item__action">
                        <div class="carts__container__item__action__quantity">
                            <span class="carts__container__item__action__quantity-minus">-</span>
                            <span class="carts__container__item__action__quantity-quantity">1</span>
                            <span class="carts__container__item__action__quantity-plus">+</span>
                            <p class="carts__container__item__action__quantity-current"><sup>đ</sup>24.000</p>
                        </div>
                        <div class="carts__container__item__action__btn">
                            <button class="delete">xóa</button>
                        </div>
                    </div>
                </div>
            </div>
            <p class="carts__container__total show">Tổng tiền 4 sản phẩm <sup>đ</sup>50000</p>
            <button class="carts__container__buy show">Mua ngay</button>


            <div class="carts__container__list__ordered ">
                <div class="carts__container__item">
                    <a href="javascript:void(0)" class="carts__container__item__detail">
                        <div class="carts__container__item__detail__img">
                            <img src="./access/imgs/product11-300x300.jpg" alt="">
                        </div>
                        <div class="carts__container__item__detail__content">
                            <p class="carts__container__item__detail__title">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            </p>
                            <div class="carts__container__item__detail__order">
                                <div class="carts__container__item__detail__order__left">
                                    <span class="carts__container__item__detail__order__left-quantity">x50</span>
                                    <span class="carts__container__item__detail__order__left-price">
                                        <span class="old-price"><sup>đ</sup>50000</span>
                                        <span class="current-price"><sup>đ</sup>50000</span>
                                    </span>
                                </div>
                                <div class="carts__container__item__detail__order__right">
                                    <span class="carts__container__item__detail__order__right-status">Đang xử lý</span><span class="carts__container__item__detail__order__right-total"><sup>đ</sup>50000</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <script type="module" src="./js/components/cartsContainer.js"></script>
        <!-- end carts__container -->