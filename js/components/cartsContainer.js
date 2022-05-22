import {$,$$} from "../configs/constants.js";
let btnCartHeaderControls=$$(".carts__container__header__control");
let cartsContainer=$(".carts__container__list__cart");
let cartOrdersContainer=$(".carts__container__list__ordered");
let cartTotal = $(".carts__container__total");
let btnCartBuy= $(".carts__container__buy");
function showCarts(){
    btnCartHeaderControls.forEach(element=>{
        element.classList.remove("active");
    })
    btnCartHeaderControls[0].classList.add("active");
    cartsContainer.classList.add("show");
    cartOrdersContainer.classList.remove("show");
    cartTotal.classList.add("show");
    btnCartBuy.classList.add("show");
}
function showCartsOrdered(){
    btnCartHeaderControls.forEach(element=>{
        element.classList.remove("active");
    })
    btnCartHeaderControls[1].classList.add("active");
    cartOrdersContainer.classList.add("show");
    cartsContainer.classList.remove("show");
    cartTotal.classList.remove("show");
    btnCartBuy.classList.remove("show");
}
showCarts();
btnCartHeaderControls.forEach(element=>{
    if(element.dataset.type=="carts"){
        element.onclick = showCarts;
    }else{
        element.onclick = showCartsOrdered;
    }
})