==
1. Lấy toàn bộ mảng cart
$cartArray = $redis->lrange($cartKey, 0, -1);
2. xóa toàn bộ mảng cart

$redis->del()
$redis->lpush($cartKey, '[]');

$redis->lpush($cartKey, arrray());

$cartKey = 'cart';

// Mảng cart
$cartList = array("id" => 1, "name" => 2);

// Chuyển đổi mảng thành chuỗi
$cartSerialized = serialize($cartList);

// Lưu chuỗi vào Redis
$redis->set($cartKey, $cartSerialized);

// Lấy chuỗi từ Redis
$cartSerialized = $redis->get($cartKey);

// Chuyển đổi chuỗi thành mảng
$cartList = unserialize($cartSerialized);
