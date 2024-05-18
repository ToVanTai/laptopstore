import { $, $$ } from "../configs/constants.js";
import { baseURL } from "../configs/configs.js";
var salesChart;
var visitorsChart;
const getTimer = function () {
    let today = new Date();
    let momentToday = moment(today);
    let momentTomorow = momentToday.add(1, 'day');

    // Lấy ngày bắt đầu của tháng
    const startOfThisMonth = moment().startOf('month').format('YYYY-MM-DD');
    // Lấy ngày kết thúc của tháng
    const endOfThisMonth = moment().endOf('month').format('YYYY-MM-DD');
    let data = [
        {
            id: -2,
            name: 'Hôm nay',
            value: {
                fromDate: momentToday.format('YYYY-MM-DD'),
                toDate: momentTomorow.format('YYYY-MM-DD'),
            }
        },
        {
            id: -1,
            name: 'Tháng này',
            value: {
                fromDate: startOfThisMonth,
                toDate: endOfThisMonth,
            }
        },
    ];
    var year = moment().year();  // Lấy năm hiện tại

    for (var month = 0; month < 12; month++) {
        var startOfMonth = moment().year(year).month(month).startOf('month').format('YYYY-MM-DD');
        var endOfMonth = moment().year(year).month(month).endOf('month').format('YYYY-MM-DD');
        data.push({
            id: month + 1,
            name: 'Tháng ' + (month + 1),
            value: {
                fromDate: startOfMonth,
                toDate: endOfMonth,
            }
        })
    }
    return data;
};

//chart
document.addEventListener("DOMContentLoaded", async function () {
    await renderSaleChart();
    await renderVisitorsChart();
    // end: Charts
});


const renderSaleChart = async function(){
    let valueChart = -1;
    if(this && this.value){
        valueChart = this.value;
    }
    let timmer = getTimer().find(x=>x.id == valueChart);
    let data = await getSaleChart(`${baseURL}admin/controller/charts.php?type=sales-chart&fromDate=${timmer.value.fromDate}&toDate=${timmer.value.toDate}`)
    
    // Dữ liệu giả (fake data)
    var categories = data.branchs.map(x=>x.name);
    var salesData = [];
    categories.forEach(item=>{
        if(data && data.listQuantity){
            let itemFind = data.listQuantity.find(x=>x.branch_name == item);
            let quantities = itemFind && itemFind.total ? itemFind.total : 0;
            salesData.push(quantities);
        }else{
            salesData.push(0);
        }
        
    })

    // Vẽ biểu đồ
    var salesChartBox = document.querySelector('#sales-chart');
    if(salesChart){
        salesChart.destroy();
    }
    salesChart = new Chart(salesChartBox, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Doanh số',
                backgroundColor: '#6610f2',
                data: salesData,
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            maintainAspectRatio: false,
            width: 450
        }
    });
};
const renderVisitorsChart = async function(){
    var visitorsChartBox = document.querySelector('#visitors-chart');
    if(visitorsChart){
        visitorsChart.destroy();
    }
    visitorsChart = new Chart(visitorsChartBox, {
        type: 'doughnut',
        data: {
            labels: ['Children', 'Teenager', 'Parent'],
            datasets: [{
                backgroundColor: ['#6610f2', '#198754', '#ffc107'],
                data: [40, 60, 80],
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true
                }
            },
            maintainAspectRatio: false,
            width: 250
        }
    })
};

async function mainFn(){
    let timmer = getTimer();
    renderSaleOption(timmer)
    renderVisitorOption(timmer)
    //render combobox và addsk khi click vào item
}
function renderSaleOption(timmer){
    let actionsElm = document.getElementById("salesChartAction");
    let listOptionHtml = '';
    timmer.forEach(element=>{
        if(-1==element.id){
            listOptionHtml+=`<option value="${element.id}" selected>${element.name}</option>`;
        }else{
            listOptionHtml+=`<option value="${element.id}">${element.name}</option>`
        }
    });
    actionsElm.innerHTML=listOptionHtml;
    actionsElm.addEventListener("change",renderSaleChart);
}

function renderVisitorOption(timmer){
    let actionsElm = document.getElementById("visitorChartAction");
    let listOptionHtml = '';
    timmer.forEach(element=>{
        if(-1==element.id){
            listOptionHtml+=`<option value="${element.id}" selected>${element.name}</option>`;
        }else{
            listOptionHtml+=`<option value="${element.id}">${element.name}</option>`
        }
    });
    actionsElm.innerHTML=listOptionHtml;
    actionsElm.addEventListener("change",renderVisitorsChart);
}
mainFn();

async function getSaleChart(url){
    return await new Promise((resolve,reject)=>{
        fetch(url,{
            credentials:"include",
            method:"GET"
        }).then(res=>{
            if(res.status==200){
                res.text().then(res=>{
                    resolve(JSON.parse(res));
                })
            }else{
                reject([]);
            }
        })
    })
}