import { $, $$, numberWithComas, validateString} from "../configs/constants.js";
import { baseUrl } from "../configs/configs.js";
let urlApi=`${baseUrl}/api/orders.php`;
let listDataOrders;
async function getListDataOrders(urlApi){
    await new Promise((resolve,reject)=>{
        fetch(`${urlApi}`,{
            credentials:'include',
            method:"GET"
        }).then(res=>{
            if(res.status==200||res.status==201){
                res.text().then(res=>{
                    listDataOrders=JSON.parse(res);
                    resolve();
                })
            }else{
                res.text().then(res=>{
                    reject(res);
                })
            }
        })
    })
}
function renderListOrders(data){
    let purchasedLists='';
    if(data.length>0){
        data.forEach(element=>{
            let totalPrice=0;
            purchasedLists+=`
            <div class="purchased__list">
                <div class="purchased__list__status">
                    <p>
                        Mã đơn hàng: ${element["orderId"]}
                    </p>
                    <p>
                        <span class="purchased__list__status-icon"><i class='bx bx-car'></i></span>
                        <span class="purchased__list__status-description">${element["statusName"]}</span>
                    </p>
                </div>`;
            element["orderDetails"].forEach(item=>{
                totalPrice+=Number(item["price"])*Number(item["quantity"]);
                purchasedLists+=`
                    <a href="${baseUrl}index.php?view=product&id=${item["productId"]}" class="purchased__list__item">
                    <div class="purchased__list__item-image">
                        <img src="${baseUrl}store/${item["background"]}" alt="">
                    </div>
                    <div class="purchased__list__item__detail">
                        <div class="purchased__list__item__detail__about">
                            <div class="purchased__list__item__detail__about-name">
                                <span>${item["model"]}</span>
                            </div>
                            <div class="purchased__list__item__detail__about-category">
                                <span>Phân loại hàng: ${item["capacityName"]}</span>
                            </div>
                            <div class="purchased__list__item__detail__about-quantity">
                                <span>x${item["quantity"]}</span>
                            </div>
                        </div>
                        <div class="purchased__list__item__detail__price">
                            <span class="current-price">${numberWithComas(item["price"])}<u>đ</u></span>
                        </div>
                    </div>
                </a>
                `;
            });
            purchasedLists+=`<div class="purchased__list__totalprice">
                    Tổng tiền:<span>${numberWithComas(totalPrice)}<u>đ</u></span>
                </div>
                <div class="purchased__list__actions">
                    <span data-id="${element["orderId"]}" class="active action">Hủy đơn hàng</span>
                    <span data-id="${element["orderId"]}" class="action">Trả hàng</span>
                </div>
            </div>`;
        });
    }
    $(".purchased__container").innerHTML=purchasedLists;
}
async function mainFn(){
    try{
        await getListDataOrders(urlApi);
        renderListOrders(listDataOrders);
    }catch{

    }
}

mainFn();