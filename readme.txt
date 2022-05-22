laptopstore
----------------------tables----------------------
*users(id, account, password, name, phone_number, address, avatar, email, role_id, created_at, updated_at)
*role(id, name)
*products(id, category_id name, price, discount, image, created_by, created_at, updated_at, quantity, description)
*categories(id, name, created_at, created_by, created_at updated_at)
*orders(id, user_id)
*order_details(id, order_id, product_id, quantity, price, created_at, updated_at)

