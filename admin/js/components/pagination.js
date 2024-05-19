export let configPagination = {
    allData: [],
    currentPage: 1,
    totalPage: 1,
    pageSize: 20,
    dataCurrent: []
}
export let myPagination = function (total, current, callBackFn) {
    try {
        // rendering pagination khi click vào pagination
        var paginationElm = document.querySelector("#pagination-table")
        var liTagHtml = ``
        if (total >= 1 && total <= 5) {
            if (current > 1) {
                liTagHtml += `<li data-index=${current - 1} class="prev">Trước</li>`
            }
            for (let i = 1; i <= total; i++) {
                if (i == current) {
                    liTagHtml += `<li class="num active">${i}</li>`
                } else {
                    liTagHtml += `<li data-index=${i} class="num">${i}</li>`
                }
            }
            if (current < total) {
                liTagHtml += `<li data-index=${current + 1} class="next">Sau</li>`
            }
        } else if (total > 5) {
            let before = current - 1
            let after = current + 1
            if (current > 1) {
                liTagHtml += `<li data-index=${current - 1} class="prev">Trước</li>`
            }
            if (current > 2) {
                liTagHtml += `<li data-index=1 class="num">1</li>`
                if (current > 3) {
                    liTagHtml += `<li class="dots">...</li>`
                }
            }
            if (current == 1) {
                before++
                after++
            }
            if (current == total) {
                before--
                after--
            }
            for (let i = before; i <= after; i++) {
                if (i == current) {
                    liTagHtml += `<li class="num active">${i}</li>`
                } else {
                    liTagHtml += `<li data-index=${i} class="num">${i}</li>`
                }
            }
            if (current < total - 1) {
                if (current < total - 2) {
                    liTagHtml += `<li class="dots">...</li>`
                }
                liTagHtml += `<li data-index=${total} class="num">${total}</li>`
            }
            if (current < total) {
                liTagHtml += `<li data-index=${current + 1} class="next">Sau</li>`
            }
        }
        paginationElm.innerHTML = liTagHtml

        // thêm sự kiện click vào pagination sau khi rendering pagination
        var paginationListItem = document.querySelectorAll("#pagination-table li:not(.dots)")
        for (let i = 0; i < paginationListItem.length; i++) {
            if (!paginationListItem[i].classList.contains("active")) {
                paginationListItem[i].addEventListener("click", function () {
                    let pageDirection = Number(this.dataset.index);
                    callBackFn(total, pageDirection)
                    myPagination(total, pageDirection, callBackFn)
                })
            }
        }
    } catch (err) {
        console.log(err);
    }


};

export let getAllData = async function (url){
    let a = new Promise((resolve, reject)=>{
        fetch(url,{
            method:"GET",
            credentials:"include"
        }).then(res=>{
            return res.text().then(resData=>{
                resData = JSON.parse(resData);
                if(resData){
                    resolve(resData);
                }else{
                    resolve([])
                }
            })
        }).catch(ex=>{
            resolve([]);
        })
    })
    return await a;
};

export let getDataCurrent = function(config){
    let start = (config.currentPage - 1) * config.pageSize;
    let end = start + config.pageSize;
    if(config.allData){
        configPagination.dataCurrent =  config.allData.slice(start, end);
    }else{
        configPagination.dataCurrent = [];
    }
}
