import {$} from "../configs/constants.js";
// navbar for mobile
let navbarOverlay = $(".navbar__content__mobile__overlay")
let navbarContentMobile = $(".navbar__content__mobile")
let btnCloseNavbarMobile = $(".navbar__content__mobile__close")
let btnOpenNavbarMobile = $(".navbar__control-mobile")
function openNavbarMobile(){
    console.log("kkk")
    navbarOverlay.classList.add("open")
    navbarContentMobile.classList.add("open")
}
function closeNavbarMobile(){
    navbarOverlay.classList.remove("open")
    navbarContentMobile.classList.remove("open")
}
btnCloseNavbarMobile.onclick = closeNavbarMobile;
navbarOverlay.onclick = closeNavbarMobile;
btnOpenNavbarMobile.onclick = openNavbarMobile;
// end navbar for mobile