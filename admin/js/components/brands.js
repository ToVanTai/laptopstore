import {$,$$} from "../configs/constants.js";
import {baseURL} from "../configs/configs.js";
import {loading, unLoading} from "../utils/utils.js";
import {myPagination, configPagination, getAllData, getDataCurrent} from "./pagination.js";
import "./table.js";
document.title="Trang quản lý hãng";
function renderTable(resData){
    let productList = document.getElementById("product__list");
    let productsHtml = "";
    if(resData){
        for(let i=0;i<resData.length;i++){
            productsHtml+=`
            <tr>
                <td>${i+1}</td>
                <td>${resData[i]["name"]}</td>
                <td><img style="height:50px; object-fit:cover" src="${baseURL}store/${resData[i]["image"]}" alt=""></td>
                <td>
                    <div class="list-link">
                        <a href="index.php?view=change-brand&id=${resData[i]["id"]}" class="link-item-2">Sửa</a> 
                    </div>
                </td>
            </tr>`
        }
        productList.innerHTML=productsHtml
    }
}

//fake 
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
        configPagination.allData = await getAllData(`${baseURL}admin/controller/brands.php`);
        configPagination.totalPage = Math.ceil(configPagination.allData.length / configPagination.pageSize);
        getDataCurrent(configPagination);
        myPagination(configPagination.totalPage, configPagination.currentPage, callBackWhenChangePageIndex);
        renderTable(configPagination.dataCurrent);
    }catch(ex){};
    unLoading();
})();
