import { $, $$, httpGetAsync, numberWithComas, validateString } from "../configs/constants.js";
import { baseUrl } from "../configs/configs.js";
let urlApiCarts = `${baseUrl}api/carts.php`;
let dataCarts;
async function getCartsData(url){
    await new Promise((resolve,reject)=>{
        fetch(url,{
            method:"GET",
            credentials:"include"
            })
            .then(res=>{
                if(res.status==200){
                    res.text().then(res=>{
                        resolve(JSON.parse(res));
                    })
                }else{
                    res.text().then(res=>{
                        reject(res);
                    })
                }
            })
        }).then(res=>{
            dataCarts=res;
        }).catch(err=>{
            alert(err);
        });
}
async function test(){
    try{
        await getCartsData(urlApiCarts);
        renderCartList(dataCarts);
    }catch{
    }
}
test();
function getTotalPrice(data){
    let result =0;
    data.forEach(element=>{
        result+=element.quantity*element["detail"]["newPrice"];
    });
    return result;
}
function renderCartList(data){
    // start render carts
    let result ="";
    let totalPrice=getTotalPrice(data);
    data.forEach(element=>{
        let urlBackground=`${baseUrl}store/${element["detail"]["background"]}`;
        let model = validateString(`${element["detail"]["model"]}`);
        let linkProduct=`${baseUrl}index.php?view=product&id=${element["productId"]}`;
        result+=`
            <tr class="cart__item">
                <td>
                    <a href="${linkProduct}">
                        <img src="${urlBackground}" alt="">
                    </a>
                </td>
                <td>
                    <a href="${linkProduct}">
                        <p>${model}</p>
                    </a>
                </td>
                <td>${element["detail"]["capacityName"]}</td>
                <td>
                    <input type="number" class="cart__item__quantity" name="quantity" data-product="${element["productId"]}" data-capacity="${element["capacityId"]}" value="${element["quantity"]}">
                </td>
                <td>
                    ${element["detail"]["newPrice"]}<u>đ</u>
                </td>
                <td>
                    <span class="cart__del" data-product="${element["productId"]}" data-capacity="${element["capacityId"]}"><i class='bx bx-trash' ></i></span>
                </td>
            </tr>
        `;
    });
    $(".carts__table").innerHTML = `
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Phân loại</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
            <th>Xóa</th>
        </tr>
        ${result}
        `;
    $(".carts__total-total").innerHTML=`
        ${numberWithComas(totalPrice)}<u>đ</u>
    `;
    // end render carts
    // start addEvent for input quantity 
    $$(".cart__item__quantity").forEach(element=>{
        element.addEventListener('change',function onChangeQuantity(){
            let quantityOld = this.value;
            let productIdChange = this.dataset.product;
            let capacityIdChange = this.dataset.capacity;
            if(quantityOld<=0){
                this.value=1;
                quantityOld=1;
            }else{
                for(let i=0;i<dataCarts.length;i++){
                    if(dataCarts[i]["productId"]==productIdChange&&dataCarts[i]["capacityId"]==capacityIdChange){
                        dataCarts[i].quantity=quantityOld;
                        $(".carts__total-total").innerHTML=`
                            ${numberWithComas(getTotalPrice(dataCarts))}<u>đ</u>
                        `;
                        break;
                    }
                }
            }
            
        })
    })
    // end addEvent for input quantity 

    //start addEvent for btn del cartItem
    $$(".cart__del").forEach(element=>{
        element.addEventListener('click',function onDeleteCart(){
            let productIdChange = this.dataset.product;
            let capacityIdChange = this.dataset.capacity;
            let indexDel = dataCarts.findIndex(element=>element["productId"]==productIdChange&&element["capacityId"]==capacityIdChange);
            if(confirm("Bạn có muấn xóa sản phẩm này khỏi giỏ hàng?")){
                dataCarts.splice(indexDel,1);
                renderCartList(dataCarts);
            }
        })
    })
    //start addEvent for btn del cartItem
}
//on update carts
$(".carts__btn-update").addEventListener('click',function onUpdateCarts(){
    if(confirm("Bạn có muấn cập nhật giỏ hàng lên máy chủ?")){
        console.log(dataCarts);
    }
})