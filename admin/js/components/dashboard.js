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
    await renderTableOrders();
    // end: Charts
});


const renderSaleChart = async function () {
    let valueChart = -1;
    if (this && this.value) {
        valueChart = this.value;
    }
    let timmer = getTimer().find(x => x.id == valueChart);
    let data = await getSaleChart(`${baseURL}admin/controller/charts.php?type=sales-chart&fromDate=${timmer.value.fromDate}&toDate=${timmer.value.toDate}`)

    // Dữ liệu giả (fake data)
    var categories = data.branchs.map(x => x.name);
    var salesData = [];
    categories.forEach(item => {
        if (data && data.listQuantity) {
            let itemFind = data.listQuantity.find(x => x.branch_name == item);
            let quantities = itemFind && itemFind.total ? itemFind.total : 0;
            salesData.push(quantities);
        } else {
            salesData.push(0);
        }

    })

    // Vẽ biểu đồ
    var salesChartBox = document.querySelector('#sales-chart');
    if (salesChart) {
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
const renderVisitorsChart = async function () {
    var visitorsChartBox = document.querySelector('#visitors-chart');
    if (visitorsChart) {
        visitorsChart.destroy();
    };
    let data = await getSaleChart(`${baseURL}admin/controller/charts.php?type=visitors-chart`)
    const revenueData = [
        { month: 'T1', id: 1, revenue: 0 },
        { month: 'T2', id: 2, revenue: 0 },
        { month: 'T3', id: 3, revenue: 0 },
        { month: 'T4', id: 4, revenue: 0 },
        { month: 'T5', id: 5, revenue: 0 },
        { month: 'T6', id: 6, revenue: 0 },
        { month: 'T7', id: 7, revenue: 0 },
        { month: 'T8', id: 8, revenue: 0 },
        { month: 'T9', id: 9, revenue: 0 },
        { month: 'T10', id: 10, revenue: 0 },
        { month: 'T11', id: 11, revenue: 0 },
        { month: 'T12', id: 12, revenue: 0 }
    ];
    revenueData.forEach(item=>{
        if(data){
            let itemFind = data.find(x=>x.month == item.id);
            if(itemFind){
                item.revenue = itemFind.total_revenue;
            }
        }
    })
    visitorsChart = new Chart(visitorsChartBox, {
        type: 'line',
        data: {
            labels: revenueData.map(data => data.month), // Lấy tên các tháng làm nhãn trục x
            datasets: [{
                label: 'Doanh thu',
                data: revenueData.map(data => data.revenue), // Lấy giá trị doanh thu làm dữ liệu
                backgroundColor: 'rgba(0, 123, 255, 0.3)', // Màu nền của đường
                borderColor: 'rgba(0, 123, 255, 1)', // Màu viền của đường
                borderWidth: 2 // Độ dày viền của đường
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true // Bắt đầu trục y từ giá trị 0
                }
            },
            maintainAspectRatio: false,
            width: 300
        }
    }
    )
};

async function mainFn() {
    let timmer = getTimer();
    renderSaleOption(timmer)
    //render combobox và addsk khi click vào item
}
function renderSaleOption(timmer) {
    let actionsElm = document.getElementById("salesChartAction");
    let listOptionHtml = '';
    timmer.forEach(element => {
        if (-1 == element.id) {
            listOptionHtml += `<option value="${element.id}" selected>${element.name}</option>`;
        } else {
            listOptionHtml += `<option value="${element.id}">${element.name}</option>`
        }
    });
    actionsElm.innerHTML = listOptionHtml;
    actionsElm.addEventListener("change", renderSaleChart);
}

mainFn();

async function getSaleChart(url) {
    return await new Promise((resolve, reject) => {
        fetch(url, {
            credentials: "include",
            method: "GET"
        }).then(res => {
            if (res.status == 200) {
                res.text().then(res => {
                    resolve(JSON.parse(res));
                })
            } else {
                reject([]);
            }
        })
    })
}

async function renderTableOrders(){
    let data = await getSaleChart(`${baseURL}admin/controller/charts.php?type=new_order`);
    if(data){
        var tableNewOrder = document.querySelector('#table-new-orders');
        let htmlTableNewOrder = '';
        data.forEach(item=>{
            htmlTableNewOrder+=`
                <tr>
                        <td>
                            ${item.name}
                        </td>
                        <td>${moment(item.created).format('YYYY-MM-DD')}</td>
                        <td><span class="status completed">${item.status_name}</span></td>
                    </tr>
            `
        })
        tableNewOrder.innerHTML = htmlTableNewOrder;
    }
}