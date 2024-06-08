import {$,$$} from "../configs/constants.js";
import {baseURL} from "../configs/configs.js";
import {loading, unLoading} from "../utils/utils.js";
import {myPagination, configPagination, getAllData, getDataCurrent} from "./pagination.js";
let ordersIdList;
let orderIdActive;//history
// let ordersList;
document.title = "Trang quản lý đơn hàng";
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

function onChangeStatus(){
    let currentElm = this.parentNode.parentNode;
    let statusCurrent12 = this.dataset.statuscurrent;
    let orderId12 = this.dataset.orderid;
    let statusChange12 = this.parentNode.querySelector(".listStatusChange").value;
    if(statusChange12!=statusCurrent12){
        if(confirm("Bạn có muấn lưu thay đổi trạng thái đơn hàng?")){
            let body = JSON.stringify({"statusChange":statusChange12,"orderId":orderId12});
            fetch(`${baseURL}admin/controller/orders.php`,{
                method:"POST",
                credentials:"include",
                body
            }).then(res=>{
                if(res.status==201||res.status==200){
                    currentElm.parentNode.removeChild(currentElm);
                    alert("Thành công");
                }else{
                    res.text().then(res=>alert(res));
                }
            })
        }
    }
}
function renderListStatusChange(statusCurrent){
    let optionHtml ='';
    //ordersList[id-1]->id,name
    if(statusCurrent==1){
        optionHtml+=`<option selected value="${ordersIdList[0]["id"]}">
            ${ordersIdList[0]["name"]}    
        </option>`;
        optionHtml+=`
            <option value="${ordersIdList[1]["id"]}">
            ${ordersIdList[1]["name"]}    
        </option>
        `;
        optionHtml+=`
            <option value="${ordersIdList[2]["id"]}">
            ${ordersIdList[2]["name"]}    
        </option>
        `;
    }else if(statusCurrent == 2){
        optionHtml+=`<option selected value="${ordersIdList[1]["id"]}">
            ${ordersIdList[1]["name"]}    
        </option>`;
    }else if(statusCurrent == 3){
        optionHtml+=`<option selected value="${ordersIdList[2]["id"]}">
            ${ordersIdList[1]["name"]}    
        </option>`;
    }
    return optionHtml;
}
async function onChangeAction(){
    try{
        loading()
        changeParamsUrl(this.value);
        orderIdActive = new URLSearchParams(window.location.search).get("id-status");
        if(!orderIdActive){
            orderIdActive=1;
        }
        configPagination.allData = await getAllData(`${baseURL}admin/controller/orders.php?status-id=${orderIdActive}`);
        configPagination.totalPage = Math.ceil(configPagination.allData.length / configPagination.pageSize);
        getDataCurrent(configPagination);
        myPagination(configPagination.totalPage, configPagination.currentPage, callBackWhenChangePageIndex);
        renderTable(configPagination.dataCurrent);
    }catch(err){
    }
    unLoading();
}

function renderTable(resData){
    let productList = document.getElementById("product__list");
    let ordersHtml = '';
    resData.forEach(element=>{
        ordersHtml+=`<tr>
        <td>${element["orderId"]}</td>
        <td>${element["createAt"]}</td>
        <td>${element["statusName"]}</td>
        <td style="width: 320px; max-width: 320px;">
            <select class="listStatusChange" style="padding:5px; display:inline-block" name="status">
                ${renderListStatusChange(element["statusId"])}
            </select>
        </td>
        <td>
            <div class="list-link">
                <div class="link-item-1 btn-change-status" data-statuscurrent=${element["statusId"]} data-orderid=${element["orderId"]}>Lưu trạng thái</div>
                <a href="${baseURL}admin/index.php?view=cart&id=${element["orderId"]}" class="link-item-2">Xem</a>
            </div>
        </td>
    </tr>
</tbody>`;
    });
    productList.innerHTML=ordersHtml;
    $$(".btn-change-status").forEach(element=>{
        element.addEventListener('click',onChangeStatus);
    })
}
function callBackWhenChangePageIndex(totalPage, currentPage){
    try {
        configPagination.totalPage = totalPage;
        configPagination.currentPage = currentPage;
        getDataCurrent(configPagination);
        renderTable(configPagination.dataCurrent);
    } catch (error) {
        
    }
    unLoading();
}

(async function () {
    //B1: get all data
    //B2: mặc định là 20 bản ghi/1 trang
    loading()
    try{
        await getOrdersIdList(`${baseURL}admin/controller/status.php`);
        orderIdActive = new URLSearchParams(window.location.search).get("id-status");
        if(!orderIdActive){
            orderIdActive=1;
        }
        renderStatus(ordersIdList);

        configPagination.allData = await getAllData(`${baseURL}admin/controller/orders.php?status-id=${orderIdActive}`);
        configPagination.totalPage = Math.ceil(configPagination.allData.length / configPagination.pageSize);
        getDataCurrent(configPagination);
        myPagination(configPagination.totalPage, configPagination.currentPage, callBackWhenChangePageIndex);
        renderTable(configPagination.dataCurrent);
    }catch(ex){
        console.log(ex)
    };
    unLoading();
})();
