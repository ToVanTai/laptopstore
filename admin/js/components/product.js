import { $, $$ } from "../configs/constants.js";
import { baseURL } from "../configs/configs.js";
import {loading, unLoading} from "../utils/utils.js";
let id = Object.fromEntries(
    new URLSearchParams(window.location.search).entries()
).id;
let product;
let capacities;
async function getProduct() {
    try {
        await new Promise((resolve, reject) => {
            fetch(`${baseURL}admin/controller/product.php?id=${id}`, {
                method: "GET",
                credentials: "include",
            }).then((res) => {
                if (res.status === 200 || res.status === 201) {
                    res.text().then((res) => {
                        product = JSON.parse(res);
                        resolve();
                    });
                } else {
                    reject();
                }
            });
        });
    } catch (err) {}
}
async function getCapacities() {
    try {
        await new Promise((resolve, reject) => {
            fetch(
                `${baseURL}admin/controller/capacities.php?product_id=${id}`,
                {
                    method: "GET",
                    credentials: "include",
                }
            ).then((res) => {
                if (res.status === 200 || res.status === 201) {
                    res.text().then((res) => {
                        capacities = JSON.parse(res);
                        resolve();
                    });
                } else {
                    reject();
                }
            });
        });
    } catch (err) {}
}
async function main() {
    try {
        loading();
        await getProduct();
        await getCapacities();
        renderProductContainer();
        unLoading();
    } catch (err) {}
}
function renderCapacities() {
    let dataRes = "";
    //
    capacities.forEach((capacity) => {
        let capacitiesHref = `index.php?view=change-capacity-product&id=${capacity['id']}&productid=${id}`;
        dataRes+=`
            <tr>
                <td>${capacity["capacity_name"]}</td>
                <td>${capacity["quantity"]}</td>
                <td>${capacity["price"]}</td>
                <td>
                    <div class="list-link">
                        <a class="link-item-2" href="${capacitiesHref}" data-id="${capacity['id']}">Sửa</a>
                    </div>
                </td>
            </tr>
        '`;
    });
    return dataRes;
}
function renderProductContainer(){
    let productContainer = document.getElementById("detail-container")
    let productContent = `
        <ul class="detail-infor">
            <li><span>Tên: </span><span>${product["model"]}</span> </li>
            <li><span>Hãng sản xuất: </span><span>${product["nameBrand"]}</span> </li>
            <li><span>Màn hình: </span><span>${product["screen"]}</span> </li>
            <li><span>RAM: </span><span>${product["RAM"]}</span> </li>
            <li><span>Hardware: </span><span>${product["hardware"]}</span> </li>
            <li><span>Hệ điều hành: </span><span>${product["OS"]}</span> </li>
            <li><span>CPU: </span><span>${product["CPU"]}</span> </li>
            <li><span>VGA: </span><span>${product["VGA"]}</span> </li>
            <li><span>Bảo hành: </span><span>${product["warranty"]}</span> </li>
            <li><span>Giảm giá: </span><span>${product["discount"]}%</span> </li>
            <li><span>Màu: </span><span>${product["color"]}</span> </li>
            <li><span>Tạo bởi: </span><span>${product["nameUser"]}</span> </li>
        </ul>
        <section class="table__body second">
            <table>
                <thead>
                    <tr>
                        <th>Ram/hardware</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    ${renderCapacities()}
                </tbody>
            </table>
        </section>
        <div class="btn-group">
            <a class="btn" href="index.php?view=add-capacity-product&id-product=${id}">Thêm</a>
            <a class="btn" href="index.php?view=change-product&id=${id}">Sửa</a>
        </div>`;
    productContainer.innerHTML=productContent
}
main();
