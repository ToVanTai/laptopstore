create read update delete
categories:
api/categories.php->readAll GET
products:
api/products.php?page=1&limit=6->readAll
api/products.php?name="kk"->readAll()
api/products.php?category="kk"->readAll()
api/products.php?id=1->readItem()


view=search &type=brand&name=DELL page= limit=
view=search &type=products&name=tovantai page= limit =
view=product&id=1

api/carts.php   getAll
api/carts.php?product_id=&capacity_id=&quantity=   post addToCart //them moi/ tang so luong
api/carts.php?product_id=&capacity_id=&quantity=   patch change quantity
api/carts.php?product_id=&capacity_id   delete deleteCart
[
    {
        "statusName":,
        "statusId":,
        "orderId":,
        "created_at":,
        "updated_at":,
        "orderDetails":[
            "productId",
            "capacityId",
            "quantity",
            "price",
            "capacityName",
            "model",data
            "background"
        ]
    },
]
*getList orderId of user    
select orders.id as orderId,status.id as statusId, status.name as statusName, orders.created_at, orders.updated_at from orders inner join status on orders.status_id = status.id inner join users on users.id = orders.user_id where orders.user_id=21
->16,17
select order_details.order_id as orderId, order_details.product_id as productId, order_details.capacity_id as capacityId, order_details.quantity as quantity, order_details.price as price, 
product_capacities.capacity_name as capacityName, products.model as model, products.background as background from
order_details inner join product_capacities on order_details.capacity_id = product_capacities.id inner join
products on product_capacities.product_id = products.id where order_details.order_id = 16 or order_details.order_id = 17 


