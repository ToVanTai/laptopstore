import { $ } from "../configs/constants.js";
import { baseUrl } from "../configs/configs.js";
// navbar for mobile
let navbarOverlay = $(".navbar__content__mobile__overlay")
let navbarContentMobile = $(".navbar__content__mobile")
let btnCloseNavbarMobile = $(".navbar__content__mobile__close")
let btnOpenNavbarMobile = $(".navbar__control-mobile")
function openNavbarMobile () {
    navbarOverlay.classList.add("open")
    navbarContentMobile.classList.add("open")
}
function closeNavbarMobile () {
    navbarOverlay.classList.remove("open")
    navbarContentMobile.classList.remove("open")
}
btnCloseNavbarMobile.onclick = closeNavbarMobile;
navbarOverlay.onclick = closeNavbarMobile;
btnOpenNavbarMobile.onclick = openNavbarMobile;
// end navbar for mobile

let btnLogout = document.getElementById("btn-logout");
if (btnLogout!=null) {
    btnLogout.addEventListener("click", function () {
        fetch(`${baseUrl}api/user.php`, {
            credentials: "include",
            method: "DELETE"
        }).then(res => {
            if (res.status == 200 || res.status == 201) {
                window.location.reload();
            } else {
                alert("ban chua dang nhap");
            }
        })
    })
}
//change avatar and username when logged

//