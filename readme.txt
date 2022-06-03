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
        "productId":...
        "capacityId":...
        "quantity":....
    },{
        "productId":...
        "capacityId":...
        "quantity":....
    }
]



