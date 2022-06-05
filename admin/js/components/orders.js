import {$,$$} from "../configs/constants.js";
import {baseURL} from "../configs/configs.js";
let ordersIdList;
let orderIdActive;
let ordersList;

async function getOrdersIdList(url){
    await new Promise((resolve,reject)=>{
        fetch(url,{
            credentials:"include",
            method:"GET"
        }).then(res=>{
            if(res.status==200){
                res.text().then(res=>{
                    ordersIdList=JSON.parse(res);
                    resolve();
                })
            }else{
                reject();
            }
        })
    })
}
async function getOrdersList(url){
    await new Promise((resolve,reject)=>{
        fetch(url,{
            credentials:"include",
            method:"GET"
        }).then(res=>{
            if(res.status==200){
                res.text().then(res=>{
                    ordersList=JSON.parse(res);
                    resolve();
                })
            }else{
                reject();
            }
        })
    })
}
async function mainFn(){
    try{
        await getOrdersIdList(`${baseURL}admin/controller/status.php`);
        orderIdActive = new URLSearchParams(window.location.search).get("id-status");
        if(!orderIdActive){
            orderIdActive=1;
        }
        renderStatus(ordersIdList);
        await getOrdersList(`${baseURL}admin/controller/orders.php?status-id=${orderIdActive}`);
        renderOrders(ordersList);
    }catch(err){
    }
}
function changeParamsUrl(data){
    const url = new URL(window.location);
    url.searchParams.set("id-status", data);
    history.pushState({},"",url);
    orderIdActive=data;
}
function renderStatus(data){
    let actionsElm = document.getElementById("actions");
    let listOptionHtml = '';
    data.forEach(element=>{
        if(orderIdActive==element.id){
            listOptionHtml+=`<option value="${element.id}" selected>${element.name}</option>`;
        }else{
            listOptionHtml+=`<option value="${element.id}">${element.name}</option>`
        }
    });
    actionsElm.innerHTML=listOptionHtml;
    actionsElm.addEventListener("change",onChangeAction);
}
function renderOrders(data){
    let ordersHtml = '';
    data.forEach(element=>{
        ordersHtml+=`<tr>
        <td>${element["orderId"]}</td>
        <td>${element["createAt"]}</td>
        <td>${element["statusName"]}</td>
        <td>
            <select name="status">
                <option value=""></option>
            </select>
            <span class="btn">Lưu trạng thái</span>
        </td>
        <td>
            <a href="" class="btn">Xem</a>
        </td>
    </tr>
</tbody>`;
    });
    $(".container table tbody").innerHTML=ordersHtml;
}
async function onChangeAction(){
    try{
        changeParamsUrl(this.value);
        await getOrdersList(`${baseURL}admin/controller/orders.php?status-id=${orderIdActive}`);
        renderOrders(ordersList);
    }catch(err){
    }
}
mainFn();