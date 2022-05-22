<!-- start products__container -->
<div class="products__container">
            <header class="products__container__header">
                <title class="products__container__header__title">
                    sản phẩm
                </title>
                <div class="products__container__header__body">
                    <div class="products__container__header__control">
                        <button
                            class="products__container__header__control__btn active"
                            data-control="1"
                        >
                            <i class="bx bx-grid-horizontal"></i>
                        </button>
                        <button
                            class="products__container__header__control__btn"
                            data-control="-1"
                        >
                            <i class="bx bx-list-ul"></i>
                        </button>
                        <span>Showing 1–6 of 24 results</span>
                    </div>
                    <div class="products__container__header__options">
                    <lable>Hãng sản xuất </lable>
                        <select name="sort">
                            <option value="1">giá thấp đến cao</option>
                            <option value="-1">giá cao đến thấp</option>
                        </select>
                    </div>
                </div>
            </header>

            <div class="products__container__body row">

                <div class="products__container__body__item col col-xs-6 col-sm-6 col-md-3 col-lg-3">
                    <a href="index.php?view=product&id=1" class="products__container__body__item-img">
                        <img src="./access/imgs/product11-300x300.jpg" alt="">
                    </a>
                    <div class="products__container__body__item-detail">
                        <a href="index.php?view=product&id=1" class="products__container__body__item-detail-name">Apple iPhone SE (Space Grey, 32GB) Mobile Phone
                        </a>
                        <div class="products__container__body__item-detail-vote">
                            <i class='active bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                        </div>
                        <div class="products__container__body__item-detail-description">
                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.
                        </div>
                        <div class="products__container__body__item-detail-price">
                            <span class="old-price">$325,00</span>
                            <span class="current-price">$325,00</span>
                        </div>
                        <a href="javascript:void(0)" class="products__container__body__item-detail-addtocart">add to cart</a>
                    </div>
                </div>
            </div>
            <div class="products__container__navigation">
                <ul>
                    <!-- <li class="button prev">prev</li>
                    <li class="numb">1</li>
                    <li class="dots">...</li>
                    <li class="numb">3</li>
                    <li class="numb active">4</li>
                    <li class="numb">5</li>
                    <li class="dots">...</li>
                    <li class="numb">7</li>
                    <li class="button next">next</li> -->
                </ul>
            </div>
        </div>
        <script type="module" src="./js/components/productsContainer.js"></script>
        <!-- end products__container -->