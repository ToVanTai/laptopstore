<?php
namespace laptopstore\model;
    /**
     * thông tin giỏ hàng trong session
     */
    class Cart {
        /**
         * giảm giá bao nhiêu % float
         */
        private $discount;

        /**
         * tên file ảnh nền text
         */
        private $background;

        /**
         * price trong (bảng product_capacities)
         */
        private $oldPrice;

        /**
         * price trong (bảng product_capacities) * discount(bảng products)
         */
        private $newPrice;

        /**
         * mẫu mã trong bảng products
         */
        private $model;
        /**
         * capacity_name trong bảng product_capacities
         */
        private $capacityName;
        /**
         * quantity trong bảng product_capacities
         */
        private $quantityRemain;
        public function __construct() {
        }
    }
?>