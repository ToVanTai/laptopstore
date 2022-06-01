import { $, $$ } from "../configs/constants.js";
import { baseUrl } from "../configs/configs.js";
// start navigation
let productNavigation = $(".products__container__navigation ul");
function renderNavigation (total, current) {
    let liTagHTML = "";
    if (total >= 1 && total <= 5) {
        if (current > 1) {
            liTagHTML += `<li data-index="${current - 1}" class="button prev">prev</li>`;
        }
        for (let i = 1; i <= total; i++) {
            if (i == current) {
                liTagHTML += `<li class="numb active">${i}</li>`
            } else {
                liTagHTML += `<li data-index="${i}" class="numb">${i}</li>`
            }
        }
        if (current < total) {
            liTagHTML += `<li data-index="${current + 1}" class="button next">next</li>`;
        }
    } else if (total > 5) {
        let before = current - 1;
        let after = current + 1;
        if (current > 1) {
            liTagHTML += `<li data-index="${current - 1}" class="button prev">prev</li>`;
        }
        if (current > 2) {
            liTagHTML += `<li data-index="${1}" class="numb">1</li>`;
            if (current > 3) {
                liTagHTML += `<li class="dots">...</li>`;
            }
        }
        if (current == 1) {
            before++;
            after++;
        }
        if (current == total) {
            before--;
            after--;
        }
        for (let i = before; i <= after; i++) {
            if (i == current) {
                liTagHTML += `<li class="numb active">${i}</li>`
            } else {
                liTagHTML += `<li data-index="${i}" class="numb">${i}</li>`
            }
        }
        if (current < total - 1) {
            if (current < total - 2) {
                liTagHTML += `<li class="dots">...</li>`;
            }
            liTagHTML += `<li data-index="${total}" class="numb">${total}</li>`;
        }
        if (current < total) {
            liTagHTML += `<li data-index="${current + 1}" class="button next">next</li>`;
        }
    }
    productNavigation.innerHTML = liTagHTML;

    let liTagElement = $$(".products__container__navigation ul li");
    liTagElement.forEach(element => {
        element.onclick = function () {
            let index = this.dataset.index;
            if (index) {
                renderNavigation(total, Number(index));
            }
        }
    })
}
renderNavigation(7, 4);
//end navagation